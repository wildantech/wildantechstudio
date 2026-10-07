<?php

use App\Models\Invitation;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('invitations:purge-expired', function (): void {
    $count = 0;
    Invitation::query()->whereNotNull('expires_at')->where('expires_at', '<=', now())
        ->chunkById(100, function ($invitations) use (&$count): void {
            foreach ($invitations as $invitation) {
                Storage::disk('public')->delete($invitation->mediaPaths());
                $invitation->delete();
                $count++;
            }
        });

    $this->info("{$count} undangan kedaluwarsa dihapus.");
})->purpose('Permanently delete expired invitations and their cover images');

Schedule::command('invitations:purge-expired')->dailyAt('02:00')->withoutOverlapping();
