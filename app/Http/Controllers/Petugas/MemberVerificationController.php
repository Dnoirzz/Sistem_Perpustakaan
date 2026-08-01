<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Mail\MemberApprovedMail;
use App\Mail\MemberRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MemberVerificationController extends Controller
{
    /**
     * Tampilkan daftar calon anggota yang berstatus PENDING.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::with(['role', 'mahasiswa.prodi', 'dosen.prodi'])
            ->where('status_verifikasi', 'pending');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dosen', function ($dq) use ($search) {
                        $dq->where('nip', 'like', "%{$search}%");
                    });
            });
        }

        $pendingMembers = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.verifikasi.index', compact('pendingMembers', 'search'));
    }

    /**
     * Disetujui (Approve) pendaftaran anggota.
     */
    public function approve(User $user)
    {
        if ($user->status_verifikasi === 'verified') {
            return redirect()->back()->with('warning', 'Akun ini sudah terverifikasi sebelumnya.');
        }

        $user->update([
            'status_verifikasi' => 'verified',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menyetujui (Approve) pendaftaran anggota baru: ' . $user->name . ' (' . $user->email . ')',
        ]);

        // Kirim Email Notifikasi Kelulusan
        try {
            Mail::to($user->email)->send(new MemberApprovedMail($user));
            Log::info("Email kelulusan verifikasi terkirim ke {$user->email}");
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email kelulusan verifikasi ke {$user->email}: " . $e->getMessage());
        }

        return redirect()->route('petugas.verifikasi.index')
            ->with('success', 'Akun anggota "' . $user->name . '" berhasil diverifikasi dan disetujui. Email konfirmasi telah dikirim.');
    }

    /**
     * Ditolak (Reject) pendaftaran anggota & Hapus data (Clean Delete).
     */
    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi agar pendaftar mengetahui penyebabnya.',
        ]);

        $userName = $user->name;
        $userEmail = $user->email;
        $reason = $request->reason;

        // Kirim Email Notifikasi Penolakan SEBELUM data dihapus
        try {
            Mail::to($userEmail)->send(new MemberRejectedMail($userName, $reason));
            Log::info("Email penolakan verifikasi terkirim ke {$userEmail}");
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email penolakan verifikasi ke {$userEmail}: " . $e->getMessage());
        }

        // Hapus file foto KTM dari storage jika ada
        if (!empty($user->foto_ktm) && Storage::disk('public')->exists($user->foto_ktm)) {
            Storage::disk('public')->delete($user->foto_ktm);
        }

        // Hapus data pengguna dari database (Clean Delete)
        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menolak & menghapus pendaftaran anggota: ' . $userName . ' (' . $userEmail . '). Alasan: ' . $reason,
        ]);

        return redirect()->route('petugas.verifikasi.index')
            ->with('success', 'Pendaftaran anggota "' . $userName . '" berhasil ditolak. Email pemberitahuan telah dikirim dan data telah dibersihkan.');
    }

    /**
     * Stream file foto KTM untuk modal preview.
     */
    public function viewKtm(User $user)
    {
        if (empty($user->foto_ktm) || !Storage::disk('public')->exists($user->foto_ktm)) {
            abort(404, 'File foto KTM tidak ditemukan.');
        }

        return Storage::disk('public')->response($user->foto_ktm);
    }
}
