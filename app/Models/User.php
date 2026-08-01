<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_DOSEN = 'dosen';
    const ROLE_MAHASISWA = 'mahasiswa';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'no_hp',
        'telegram_chat_id',
        'status_verifikasi',
        'foto_ktm',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki satu Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Relasi: User memiliki satu profil Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki satu profil Dosen
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki satu profil Petugas
     */
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Loan
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Antrian
     */
    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Penalty
     */
    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Recommendation
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Notification
     */
    public function customNotifications()
    {
        return $this->hasMany(NotificationCustom::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Activity Log
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: User memiliki banyak Vote
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id', 'user_id');
    }

    /**
     * Helper: Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->role_name === 'admin';
    }

    /**
     * Helper: Cek apakah user adalah petugas
     */
    public function isPetugas(): bool
    {
        return $this->role && $this->role->role_name === 'petugas';
    }

    /**
     * Helper: Cek apakah user adalah dosen
     */
    public function isDosen(): bool
    {
        return $this->role && $this->role->role_name === 'dosen';
    }

    /**
     * Helper: Cek apakah user adalah mahasiswa
     */
    public function isMahasiswa(): bool
    {
        return $this->role && $this->role->role_name === 'mahasiswa';
    }

    /**
     * Helper: Cek apakah akun user telah terverifikasi
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    /**
     * Helper: Cek apakah akun user masih berstatus pending
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }
}
