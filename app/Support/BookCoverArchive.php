<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class BookCoverArchive
{
    private const BACKUP_DIR = 'seed-assets/book-covers';

    public static function backupPath(string $coverPath): string
    {
        return self::BACKUP_DIR . '/' . basename(str_replace('\\', '/', $coverPath));
    }

    public static function backupAbsolutePath(string $coverPath): string
    {
        return public_path(self::backupPath($coverPath));
    }

    public static function backupExists(string $coverPath): bool
    {
        return file_exists(self::backupAbsolutePath($coverPath));
    }

    public static function mirrorToBackup(string $coverPath): void
    {
        $sourcePath = str_replace('\\', '/', $coverPath);

        if (! Storage::disk('public')->exists($sourcePath)) {
            return;
        }

        $absolute = self::backupAbsolutePath($sourcePath);
        $directory = dirname($absolute);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($absolute, Storage::disk('public')->get($sourcePath));
    }

    public static function restoreToStorage(string $coverPath): bool
    {
        $source = self::backupAbsolutePath($coverPath);

        if (! file_exists($source)) {
            return false;
        }

        $normalized = str_replace('\\', '/', $coverPath);

        if (! Storage::disk('public')->exists($normalized)) {
            Storage::disk('public')->put($normalized, file_get_contents($source));
        }

        return true;
    }
}
