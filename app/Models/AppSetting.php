<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    /**
     * Dapatkan nilai setting berdasarkan key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set atau update nilai setting.
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $description
     * @return self
     */
    public static function set(string $key, $value, ?string $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description ?? (self::where('key', $key)->value('description') ?? '')
            ]
        );

        return $setting;
    }
}
