<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCustom extends Model
{
    use HasFactory;

    protected $table = 'notifications_custom';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'url',
        'type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi: Notification milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Scope: Hanya notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Helper: Kirim notifikasi ke 1 pengguna
     */
    public static function send(int $userId, string $title, string $message, ?string $url = null, string $type = 'info'): self
    {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'type' => $type,
            'is_read' => false,
        ]);
    }

    /**
     * Helper: Kirim notifikasi ke seluruh pengguna dengan role tertentu
     */
    public static function sendToRoles(array $roleNames, string $title, string $message, ?string $url = null, string $type = 'info'): void
    {
        $userIds = User::whereHas('role', function ($q) use ($roleNames) {
            $q->whereIn('role_name', $roleNames);
        })->pluck('user_id');

        foreach ($userIds as $uid) {
            self::create([
                'user_id' => $uid,
                'title' => $title,
                'message' => $message,
                'url' => $url,
                'type' => $type,
                'is_read' => false,
            ]);
        }
    }
}
