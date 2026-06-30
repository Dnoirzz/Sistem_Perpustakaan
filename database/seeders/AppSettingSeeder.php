<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'fonnte_token',
                'value' => '',
                'description' => 'Fonnte API Token untuk mengirim notifikasi WhatsApp'
            ],
            [
                'key' => 'wa_notification_enabled',
                'value' => 'true',
                'description' => 'Status aktifasi notifikasi WhatsApp (true/false)'
            ],
            [
                'key' => 'wa_sender_name',
                'value' => 'Perpustakaan PSDKU POLNEP',
                'description' => 'Nama pengirim perpustakaan yang dicantumkan pada footer pesan'
            ]
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'description' => $setting['description']
                ]
            );
        }
    }
}
