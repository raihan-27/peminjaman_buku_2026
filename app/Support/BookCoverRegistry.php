<?php

namespace App\Support;

use App\Models\Book;
use Illuminate\Support\Str;

class BookCoverRegistry
{
    private const REGISTRY_PATH = 'app/book-cover-registry.json';
    private const BACKUP_REGISTRY_PATH = 'seed-assets/book-cover-registry.json';

    public static function path(): string
    {
        return storage_path(self::REGISTRY_PATH);
    }

    public static function load(): array
    {
        $contents = null;

        if (file_exists(self::path())) {
            $contents = file_get_contents(self::path());
        } elseif (file_exists(self::backupPath())) {
            $contents = file_get_contents(self::backupPath());
        }

        if ($contents === null) {
            return [];
        }

        $decoded = json_decode($contents ?: '[]', true);

        return is_array($decoded) ? array_values($decoded) : [];
    }

    public static function save(array $entries): void
    {
        $payload = json_encode(array_values($entries), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        self::write(self::path(), $payload);
        self::write(self::backupPath(), $payload);
    }

    public static function sync(Book $book): void
    {
        $entries = collect(self::load());
        $key = self::makeKey($book->title, $book->author);

        if (! $book->cover_path) {
            self::remove($book);

            return;
        }

        $entry = [
            'key' => $key,
            'title' => $book->title,
            'author' => $book->author,
            'cover_path' => str_replace('\\', '/', $book->cover_path),
        ];

        $updated = $entries
            ->reject(fn (array $item) => ($item['key'] ?? '') === $key)
            ->push($entry)
            ->values()
            ->all();

        self::save($updated);
    }

    public static function remove(Book $book): void
    {
        $entries = collect(self::load())
            ->reject(function (array $item) use ($book) {
                return ($item['key'] ?? '') === self::makeKey($book->title, $book->author)
                    || ($item['cover_path'] ?? null) === $book->cover_path;
            })
            ->values()
            ->all();

        self::save($entries);
    }

    public static function coverPathFor(string $title, string $author): ?string
    {
        $entry = collect(self::load())
            ->first(fn (array $item) => ($item['key'] ?? '') === self::makeKey($title, $author));

        return $entry['cover_path'] ?? null;
    }

    public static function seedFallback(array $bookRows, array $coverFiles): array
    {
        $coverFiles = array_values(array_filter($coverFiles));
        sort($coverFiles, SORT_NATURAL | SORT_FLAG_CASE);

        $entries = [];

        foreach ($bookRows as $index => $book) {
            $coverPath = $coverFiles[$index] ?? null;

            if (! $coverPath) {
                continue;
            }

            $entries[] = [
                'key' => self::makeKey($book['title'], $book['author']),
                'title' => $book['title'],
                'author' => $book['author'],
                'cover_path' => str_replace('\\', '/', $coverPath),
            ];
        }

        self::save($entries);

        return $entries;
    }

    private static function makeKey(string $title, string $author): string
    {
        $normalized = Str::of($title . '|' . $author)
            ->lower()
            ->squish();

        return (string) $normalized;
    }

    private static function backupPath(): string
    {
        return public_path(self::BACKUP_REGISTRY_PATH);
    }

    private static function write(string $path, string $payload): void
    {
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $payload);
    }
}
