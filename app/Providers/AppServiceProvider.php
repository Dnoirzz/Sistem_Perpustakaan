<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS when behind a reverse proxy (e.g. Cloudflare Tunnel / Ngrok HTTPS)
        if ($this->app->environment('production', 'staging') && !in_array(request()->getHost(), ['127.0.0.1', 'localhost'])) {
            URL::forceScheme('https');
        }

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers();
        });

        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'laporan-pkl' => \App\Models\LaporanPkl::class,
            'proposal-ta' => \App\Models\ProposalTa::class,
            'laporan-ta' => \App\Models\LaporanTugasAkhir::class,
        ]);

        try {
            // Overwrite mail configuration at boot time if app_settings table exists
            if (Schema::hasTable('app_settings')) {
                $mailMailer = AppSetting::get('mail_mailer');
                if ($mailMailer) {
                    config(['mail.default' => $mailMailer]);
                }

                $mailHost = AppSetting::get('mail_host');
                if ($mailHost !== null) {
                    config(['mail.mailers.smtp.host' => $mailHost]);
                }

                $mailPort = AppSetting::get('mail_port');
                if ($mailPort !== null) {
                    config(['mail.mailers.smtp.port' => intval($mailPort)]);
                }

                $mailEncryption = AppSetting::get('mail_encryption');
                if ($mailEncryption !== null) {
                    config(['mail.mailers.smtp.encryption' => $mailEncryption === 'none' ? null : $mailEncryption]);
                }

                $mailUsername = AppSetting::get('mail_username');
                if ($mailUsername !== null) {
                    config(['mail.mailers.smtp.username' => $mailUsername]);
                }

                $mailPassword = AppSetting::get('mail_password');
                if ($mailPassword !== null) {
                    config(['mail.mailers.smtp.password' => $mailPassword]);
                }

                $mailFromAddress = AppSetting::get('mail_from_address');
                if ($mailFromAddress !== null) {
                    config(['mail.from.address' => $mailFromAddress]);
                }

                $mailFromName = AppSetting::get('mail_from_name');
                if ($mailFromName !== null) {
                    config(['mail.from.name' => $mailFromName]);
                }
            }
        } catch (\Throwable $e) {
            // Avoid failing if DB is not migrated or during console command executions
        }
    }
}
