<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\MailModel;

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
    public function boot()
    {
        try {
            $mailConfig = MailModel::first();
            if ($mailConfig) {
                $config = [
                    'transport' => $mailConfig->mail_mailer, // Updated to 'transport'
                    'host' => $mailConfig->mail_host,
                    'port' => $mailConfig->mail_port,
                    'username' => $mailConfig->mail_username,
                    'password' => $mailConfig->mail_password,
                    'encryption' => $mailConfig->mail_encryption,
                    'from' => [
                        'address' => $mailConfig->mail_from_address,
                        'name' => $mailConfig->mail_from_name,
                    ],
                ];

                Config::set('mail.mailers.smtp', $config);
                Config::set('mail.from.address', $mailConfig->mail_from_address); // Corrected from 'from_address' to 'mail_from_address'
                Config::set('mail.from.name', $mailConfig->mail_from_name); // Corrected from 'from_name' to 'mail_from_name'
            } else {
                Log::warning('No mail configuration found in the database.');
            }
        } catch (\Exception $e) {
            Log::error('Error setting mail configuration: ' . $e->getMessage());
        }
    }
}
