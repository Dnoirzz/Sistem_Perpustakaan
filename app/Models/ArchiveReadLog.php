<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveReadLog extends Model
{
    use HasFactory;

    protected $table = 'archive_read_logs';

    protected $fillable = [
        'user_id',
        'archive_id',
        'archive_type',
        'finished_at',
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];

    /**
     * Relasi: ArchiveReadLog milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi polimorfik ke model Arsip asli (LaporanPkl, ProposalTa, LaporanTa)
     */
    public function archive()
    {
        return $this->morphTo('archive', 'archive_type', 'archive_id');
    }
}
