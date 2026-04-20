<?php

namespace App\Support;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookCoverSyncService
{
    public function sync(bool $dryRun = false): array
    {
        $books = Book::orderBy('id')->get();
        $stats = [
            'books' => $books->count(),
            'synced' => 0,
            'restored_to_storage' => 0,
            'mirrored_to_backup' => 0,
            'updated_db' => 0,
            'missing' => 0,
        ];

        $registryEntries = [];

        foreach ($books as $book) {
            $coverPath = $book->cover_path ?: BookCoverRegistry::coverPathFor($book->title, $book->author);

            if (! $coverPath) {
                $stats['missing']++;
                continue;
            }

            $coverPath = str_replace('\\', '/', $coverPath);

            if (! $book->cover_path && ! $dryRun) {
                $book->cover_path = $coverPath;
                $book->save();
                $stats['updated_db']++;
            }

            if (Storage::disk('public')->exists($coverPath)) {
                if (! $dryRun) {
                    BookCoverArchive::mirrorToBackup($coverPath);
                }

                $stats['mirrored_to_backup']++;
            } else {
                $restored = $dryRun ? file_exists(BookCoverArchive::backupAbsolutePath($coverPath)) : BookCoverArchive::restoreToStorage($coverPath);

                if ($restored) {
                    $stats['restored_to_storage']++;
                    if (! $dryRun) {
                        BookCoverArchive::mirrorToBackup($coverPath);
                    }
                }
            }

            $registryEntries[] = [
                'key' => $this->makeKey($book->title, $book->author),
                'title' => $book->title,
                'author' => $book->author,
                'cover_path' => $coverPath,
            ];

            $stats['synced']++;
        }

        if (! $dryRun) {
            BookCoverRegistry::save($registryEntries);

            $this->restoreMissingFromBackup($books);
        }

        return $stats;
    }

    private function restoreMissingFromBackup($books): void
    {
        foreach ($books as $book) {
            if (! $book->cover_path) {
                continue;
            }

            $coverPath = str_replace('\\', '/', $book->cover_path);

            if (Storage::disk('public')->exists($coverPath)) {
                continue;
            }

            BookCoverArchive::restoreToStorage($coverPath);
        }
    }

    private function makeKey(string $title, string $author): string
    {
        return (string) Str::of($title . '|' . $author)->lower()->squish();
    }
}
