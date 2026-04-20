<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Menampilkan form tambah buku
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Menyimpan buku baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['cover_path'] = $this->storeBookCover($request->file('cover'));
        unset($validated['cover']);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail buku
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Menampilkan form edit buku
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update data buku
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $this->deleteBookCover($book->cover_path);
            $validated['cover_path'] = $this->storeBookCover($request->file('cover'));
        }

        unset($validated['cover']);
        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Hapus buku
     */
    public function destroy(Book $book)
    {
        $this->deleteBookCover($book->cover_path);
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    private function storeBookCover(UploadedFile $cover): string
    {
        $path = $cover->store('book-covers', 'public');
        // Normalize path to use forward slashes for URLs
        return str_replace('\\', '/', $path);
    }

    private function deleteBookCover(?string $coverPath): void
    {
        if ($coverPath) {
            Storage::disk('public')->delete($coverPath);
        }
    }
}
