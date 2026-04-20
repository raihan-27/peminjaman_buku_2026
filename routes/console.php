<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Support\BookCoverSyncService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('covers:sync {--dry-run : Show what would change without writing files}', function () {
    /** @var BookCoverSyncService $service */
    $service = app(BookCoverSyncService::class);
    $stats = $service->sync((bool) $this->option('dry-run'));

    $this->line('Cover sync completed.');
    $this->line('Books scanned: ' . $stats['books']);
    $this->line('Books synced: ' . $stats['synced']);
    $this->line('DB updated: ' . $stats['updated_db']);
    $this->line('Restored to storage: ' . $stats['restored_to_storage']);
    $this->line('Mirrored to backup: ' . $stats['mirrored_to_backup']);
    $this->line('Missing covers: ' . $stats['missing']);
    if ($this->option('dry-run')) {
        $this->comment('Dry run mode: no files or database rows were written.');
    }
})->purpose('Sync book covers between database, storage, and backup files');
