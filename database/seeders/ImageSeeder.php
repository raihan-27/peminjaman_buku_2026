<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Support\BookCoverArchive;
use App\Support\BookCoverRegistry;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = DB::table('books')->orderBy('id')->get();
        $bookCovers = Storage::disk('public')->files('book-covers');
        $backupCovers = collect(glob(public_path('seed-assets/book-covers/*')) ?: [])
            ->map(fn (string $path) => 'book-covers/' . basename($path))
            ->values()
            ->all();

        $registry = BookCoverRegistry::load();

        if (empty($registry)) {
            BookCoverRegistry::seedFallback(
                $books->map(fn ($book) => [
                    'title' => $book->title,
                    'author' => $book->author,
                ])->all(),
                ! empty($bookCovers) ? $bookCovers : $backupCovers
            );
        }

        $fallbackSource = ! empty($bookCovers) ? $bookCovers : $backupCovers;

        $fallbackCovers = collect($fallbackSource)
            ->sort()
            ->values();

        foreach ($books as $index => $book) {
            $coverPath = BookCoverRegistry::coverPathFor($book->title, $book->author)
                ?? $fallbackCovers->get($index);

            if ($coverPath) {
                BookCoverArchive::restoreToStorage($coverPath);
                DB::table('books')
                    ->where('id', $book->id)
                    ->update(['cover_path' => str_replace('\\', '/', $coverPath)]);
            }
        }

        // Assign profile pictures to users
        $profilePictures = Storage::disk('public')->files('profile-pictures');
        $users = DB::table('users')->get();

        foreach ($users as $index => $user) {
            if (isset($profilePictures[$index])) {
                $profilePath = $profilePictures[$index];
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['profile_picture' => $profilePath]);
            }
        }
    }
}
