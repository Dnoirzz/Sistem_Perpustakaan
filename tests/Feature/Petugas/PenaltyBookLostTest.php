<?php

namespace Tests\Feature\Petugas;

use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Loan;
use App\Models\Penalty;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenaltyBookLostTest extends TestCase
{
    use RefreshDatabase;

    private User $petugas;
    private User $member;
    private Book $book;
    private Collection $collection;

    protected function setUp(): void
    {
        parent::setUp();

        $petugasRole = Role::firstOrCreate(['role_name' => 'petugas']);
        $memberRole = Role::firstOrCreate(['role_name' => 'mahasiswa']);

        $this->petugas = User::create([
            'role_id' => $petugasRole->role_id,
            'name' => 'Petugas Uji',
            'email' => 'petugas-uji@example.com',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $this->member = User::create([
            'role_id' => $memberRole->role_id,
            'name' => 'Anggota Uji',
            'email' => 'anggota-uji@example.com',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        $category = Category::create(['kategori_name' => 'Kategori Uji']);
        $this->book = Book::create([
            'kategori_id' => $category->kategori_id,
            'judul' => 'Buku Uji Kehilangan',
            'author' => 'Penulis Uji',
            'stock' => 0,
        ]);
        $this->collection = $this->book->collection()->firstOrFail();
    }

    public function test_cash_processing_marks_loan_lost_without_restocking(): void
    {
        $loan = $this->makeLoan();

        $response = $this->processLost($loan, [
            'settlement_method' => 'uang_tunai',
            'amount' => 25000,
            'description' => 'Anggota melaporkan buku hilang.',
        ]);

        $response->assertRedirect(route('petugas.penalties.index'));
        $this->assertLostLoanAndPenalty($loan, 'uang_tunai', 25000);
        $this->assertSame(0, $this->collection->fresh()->stock);
    }

    public function test_book_replacement_processing_restock_one_copy(): void
    {
        $loan = $this->makeLoan();

        $this->processLost($loan, [
            'settlement_method' => 'ganti_buku',
            'description' => 'Buku hilang dan diganti dengan eksemplar baru.',
        ])->assertRedirect(route('petugas.penalties.index'));

        $this->assertLostLoanAndPenalty($loan, 'ganti_buku', 0);
        $this->assertSame(1, $this->collection->fresh()->stock);
    }

    public function test_combination_processing_restock_one_copy_and_store_amount(): void
    {
        $loan = $this->makeLoan();

        $this->processLost($loan, [
            'settlement_method' => 'kombinasi',
            'amount' => 10000,
            'description' => 'Buku hilang, anggota mengganti buku dan membayar selisih.',
        ])->assertRedirect(route('petugas.penalties.index'));

        $this->assertLostLoanAndPenalty($loan, 'kombinasi', 10000);
        $this->assertSame(1, $this->collection->fresh()->stock);
    }

    public function test_overdue_lost_processing_also_records_late_penalty_once(): void
    {
        $loan = $this->makeLoan(btsWaktu: today()->subDays(3), status: 'terlambat');

        $this->processLost($loan, [
            'settlement_method' => 'uang_tunai',
            'amount' => 15000,
            'description' => 'Buku hilang setelah melewati batas pengembalian.',
        ])->assertRedirect(route('petugas.penalties.index'));

        $this->assertSame('hilang', $loan->fresh()->status);
        $this->assertSame(1, $loan->penalties()->where('type', 'kehilangan')->count());
        $this->assertSame(1, $loan->penalties()->where('type', 'keterlambatan')->count());
        $this->assertSame(2, $loan->penalties()->count());
    }

    public function test_lost_processing_requires_description_and_cash_amount(): void
    {
        $loan = $this->makeLoan();

        $response = $this->processLost($loan, [
            'settlement_method' => 'uang_tunai',
        ]);

        $response->assertSessionHasErrors(['description', 'amount']);
        $this->assertSame('dipinjam', $loan->fresh()->status);
        $this->assertSame(0, $loan->penalties()->count());
    }

    public function test_returned_or_lost_loan_cannot_be_processed_again(): void
    {
        $returnedLoan = $this->makeLoan();
        $returnedLoan->update(['status' => 'dikembalikan', 'tgl_kembali' => today()]);

        $this->processLost($returnedLoan, [
            'settlement_method' => 'uang_tunai',
            'amount' => 5000,
            'description' => 'Percobaan proses ulang.',
        ])->assertSessionHasErrors('loan_id');

        $lostLoan = $this->makeLoan();
        $this->processLost($lostLoan, [
            'settlement_method' => 'uang_tunai',
            'amount' => 5000,
            'description' => 'Proses pertama.',
        ])->assertRedirect(route('petugas.penalties.index'));

        $this->processLost($lostLoan->fresh(), [
            'settlement_method' => 'uang_tunai',
            'amount' => 5000,
            'description' => 'Percobaan proses kedua.',
        ])->assertSessionHasErrors('loan_id');

        $this->assertSame(1, $lostLoan->penalties()->where('type', 'kehilangan')->count());
    }

    public function test_return_modal_no_longer_contains_lost_book_option(): void
    {
        $loan = $this->makeLoan();

        $response = $this->actingAs($this->petugas)
            ->get(route('petugas.returns.index'));

        $response->assertOk()
            ->assertSee('Checklist Kondisi Fisik')
            ->assertDontSee('return-mode-lost')
            ->assertDontSee('name="is_lost"');
    }

    private function processLost(Loan $loan, array $data)
    {
        return $this->actingAs($this->petugas)
            ->from(route('petugas.penalties.create'))
            ->post(route('petugas.penalties.store'), array_merge([
                'loan_id' => $loan->loan_id,
            ], $data));
    }

    private function makeLoan(?\DateTimeInterface $btsWaktu = null, string $status = 'dipinjam'): Loan
    {
        return Loan::create([
            'user_id' => $this->member->user_id,
            'koleksi_id' => $this->collection->koleksi_id,
            'tgl_pinjam' => today()->subDays(2),
            'bts_waktu' => $btsWaktu ?? today()->addDays(5),
            'status' => $status,
        ]);
    }

    private function assertLostLoanAndPenalty(Loan $loan, string $method, float $amount): void
    {
        $loan->refresh();
        $penalty = $loan->penalties()->where('type', 'kehilangan')->firstOrFail();

        $this->assertSame('hilang', $loan->status);
        $this->assertTrue($loan->tgl_kembali->isToday());
        $this->assertSame('bermasalah', $loan->return_condition_status);
        $this->assertNull($loan->return_condition_checks);
        $this->assertSame($penalty->description, $loan->return_condition_notes);
        $this->assertSame($method, $penalty->penalti_type);
        $this->assertSame($amount, (float) $penalty->amount);
        $this->assertDatabaseHas('notifications_custom', [
            'user_id' => $this->member->user_id,
            'title' => 'Proses Buku Hilang',
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->petugas->user_id,
        ]);
    }
}
