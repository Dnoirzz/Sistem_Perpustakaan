<?php

namespace App\Support;

use App\Models\Book;
use App\Models\Collection as LibraryCollection;
use App\Models\LaporanPkl;
use App\Models\LaporanTugasAkhir;
use App\Models\ProposalTa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ArsipDigital
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_DIVERIFIKASI = 'diverifikasi';
    public const STATUS_AKTIF = 'aktif';
    public const STATUS_DITOLAK = 'ditolak';

    public static function definitions(): array
    {
        return [
            'laporan-pkl' => [
                'model' => LaporanPkl::class,
                'table' => 'laporan_pkl',
                'title_field' => 'judul_pkl',
                'item_type' => 'laporan_pkl',
                'label' => 'Laporan PKL',
                'full_label' => 'Laporan Praktik Kerja Lapangan',
                'code' => 'PKL',
            ],
            'proposal-ta' => [
                'model' => ProposalTa::class,
                'table' => 'proposal_ta',
                'title_field' => 'judul_proposal',
                'item_type' => 'proposal_ta',
                'label' => 'Proposal TA',
                'full_label' => 'Proposal Tugas Akhir',
                'code' => 'PTA',
            ],
            'laporan-ta' => [
                'model' => LaporanTugasAkhir::class,
                'table' => 'laporan_tugas_akhir',
                'title_field' => 'judul_tgs_akhir',
                'item_type' => 'laporan_ta',
                'label' => 'Laporan TA',
                'full_label' => 'Laporan Tugas Akhir',
                'code' => 'LTA',
            ],
        ];
    }

    public static function definition(string $type): array
    {
        $definition = static::definitions()[$type] ?? null;

        if (! $definition) {
            throw new InvalidArgumentException("Tipe arsip [$type] tidak dikenali.");
        }

        return $definition;
    }

    public static function typeOptions(): array
    {
        return collect(static::definitions())
            ->map(fn (array $definition, string $type) => [
                'value' => $type,
                'label' => $definition['full_label'],
            ])
            ->values()
            ->all();
    }

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => 'Pending',
            static::STATUS_DIVERIFIKASI => 'Diverifikasi',
            static::STATUS_AKTIF => 'Aktif',
            static::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    public static function catalogStatuses(): array
    {
        return [static::STATUS_DIVERIFIKASI, static::STATUS_AKTIF];
    }

    public static function editableStatuses(): array
    {
        return [static::STATUS_PENDING, static::STATUS_DITOLAK];
    }

    public static function resolveFromModel(EloquentModel $archive): array
    {
        foreach (static::definitions() as $type => $definition) {
            if ($archive instanceof $definition['model']) {
                return $definition + ['type' => $type];
            }
        }

        throw new InvalidArgumentException('Model arsip tidak dikenali.');
    }

    public static function titleField(string $type): string
    {
        return static::definition($type)['title_field'];
    }

    public static function itemType(string $type): string
    {
        return static::definition($type)['item_type'];
    }

    public static function title(EloquentModel $archive): string
    {
        $definition = static::resolveFromModel($archive);

        return (string) $archive->{$definition['title_field']};
    }

    public static function buildPayload(string $type, array $validated): array
    {
        $titleField = static::titleField($type);

        $payload = [
            'pembimbing' => $validated['pembimbing'] ?? null,
            'penguji_1' => $validated['penguji_1'] ?? null,
            'penguji_2' => $validated['penguji_2'] ?? null,
            'tahun' => $validated['tahun'] ?? null,
            $titleField => $validated['judul'],
        ];

        if ($type === 'laporan-pkl') {
            $payload['nama_tempat_pkl'] = $validated['nama_tempat_pkl'] ?? null;
        }

        return $payload;
    }

    public static function query(string $type, array $relations = []): Builder
    {
        $definition = static::definition($type);
        $query = $definition['model']::query();

        if ($relations !== []) {
            $query->with($relations);
        }

        return $query;
    }

    public static function findOrFail(string $type, int|string $id, array $relations = []): EloquentModel
    {
        return static::query($type, $relations)->findOrFail($id);
    }

    public static function studentHistory(int $mahasiswaId): Collection
    {
        return collect(static::definitions())
            ->flatMap(function (array $definition, string $type) use ($mahasiswaId) {
                return $definition['model']::with(['mahasiswa.user', 'mahasiswa.prodi', 'collection'])
                    ->where('mahasiswa_id', $mahasiswaId)
                    ->get()
                    ->map(fn (EloquentModel $archive) => static::toSummary($archive, $type));
            })
            ->sortByDesc('created_at')
            ->values();
    }

    public static function catalog(array $filters = []): Collection
    {
        return collect(static::definitions())
            ->flatMap(function (array $definition, string $type) use ($filters) {
                $titleField = $definition['title_field'];
                $query = $definition['model']::with(['mahasiswa.user', 'mahasiswa.prodi', 'collection'])
                    ->whereIn('status', static::catalogStatuses());

                if (! empty($filters['year'])) {
                    $query->where('tahun', $filters['year']);
                }

                if (! empty($filters['prodi_id'])) {
                    $query->whereHas('mahasiswa', function (Builder $builder) use ($filters) {
                        $builder->where('prodi_id', $filters['prodi_id']);
                    });
                }

                if (! empty($filters['search'])) {
                    $search = $filters['search'];
                    $query->where(function (Builder $builder) use ($search, $titleField) {
                        $builder->where($titleField, 'like', "%{$search}%")
                            ->orWhere('pembimbing', 'like', "%{$search}%")
                            ->orWhereHas('mahasiswa.user', function (Builder $userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('mahasiswa.prodi', function (Builder $prodiQuery) use ($search) {
                                $prodiQuery->where('nama_prodi', 'like', "%{$search}%");
                            });
                    });
                }

                return $query->get()->map(fn (EloquentModel $archive) => static::toSummary($archive, $type));
            })
            ->sortByDesc('created_at')
            ->values();
    }

    public static function toSummary(EloquentModel $archive, ?string $type = null): array
    {
        $definition = $type
            ? static::definition($type) + ['type' => $type]
            : static::resolveFromModel($archive);

        return [
            'id' => $archive->getKey(),
            'type' => $definition['type'] ?? $type,
            'type_label' => $definition['label'],
            'type_full_label' => $definition['full_label'],
            'title' => (string) $archive->{$definition['title_field']},
            'status' => $archive->status,
            'year' => $archive->tahun,
            'pembimbing' => $archive->pembimbing,
            'nama_tempat_pkl' => $archive->nama_tempat_pkl ?? null,
            'created_at' => $archive->created_at,
            'updated_at' => $archive->updated_at,
            'mahasiswa_name' => $archive->mahasiswa?->user?->name,
            'nim' => $archive->mahasiswa?->nim,
            'prodi' => $archive->mahasiswa?->prodi?->nama_prodi,
            'preview_pdf' => $archive->preview_pdf,
            'collection' => $archive->collection,
            'model' => $archive,
        ];
    }

    public static function matchingCollectionIds(string $search): array
    {
        $collectionIds = collect();

        $bookIds = Book::query()
            ->where(function (Builder $builder) use ($search) {
                $builder->where('judul', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            })
            ->pluck('buku_id');

        if ($bookIds->isNotEmpty()) {
            $collectionIds = $collectionIds->merge(
                LibraryCollection::query()
                    ->where('item_type', 'book')
                    ->whereIn('item_id', $bookIds)
                    ->pluck('koleksi_id')
            );
        }

        foreach (static::definitions() as $definition) {
            $archiveIds = $definition['model']::query()
                ->where(function (Builder $builder) use ($search, $definition) {
                    $builder->where($definition['title_field'], 'like', "%{$search}%")
                        ->orWhere('pembimbing', 'like', "%{$search}%");
                })
                ->pluck('id');

            if ($archiveIds->isEmpty()) {
                continue;
            }

            $collectionIds = $collectionIds->merge(
                LibraryCollection::query()
                    ->where('item_type', $definition['item_type'])
                    ->whereIn('item_id', $archiveIds)
                    ->pluck('koleksi_id')
            );
        }

        return $collectionIds->unique()->values()->all();
    }
}
