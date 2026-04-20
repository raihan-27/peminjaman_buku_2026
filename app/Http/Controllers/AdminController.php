<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Support\BookCoverArchive;
use App\Support\BookCoverRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function books()
    {
        $books = Book::orderBy('title')->get();
        return view('admin.books.index', compact('books'));
    }

    public function booksCreate()
    {
        return view('admin.books.create');
    }

    public function booksStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'stock' => 'required|integer|min:1|max:100',
            'category' => 'required|string|max:100',
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('cover');
        $data['cover_path'] = $this->storeBookCover($request->file('cover'));

        $book = Book::create($data);
        BookCoverRegistry::sync($book);
        return redirect()->route('admin.books')->with('success', 'Buku ditambahkan!');
    }

    public function booksEdit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function booksUpdate(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'stock' => 'required|integer|min:0|max:100',
            'category' => 'required|string|max:100',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('cover');

        if ($request->hasFile('cover')) {
            $this->deleteBookCover($book->cover_path);
            $data['cover_path'] = $this->storeBookCover($request->file('cover'));
        }

        $book->update($data);
        BookCoverRegistry::sync($book->fresh());
        return redirect()->route('admin.books')->with('success', 'Buku diperbarui!');
    }

    public function booksDestroy(Book $book)
    {
        $this->deleteBookCover($book->cover_path);
        BookCoverRegistry::remove($book);
        $book->delete();
        return redirect()->route('admin.books')->with('success', 'Buku dihapus!');
    }

    public function loans()
    {
        $loans = Loan::with(['user', 'book'])->orderBy('created_at', 'desc')->get();
        return view('admin.loans', compact('loans'));
    }

    public function loanApprove(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $loan->update(['status' => 'approved']);
        $loan->book->decrement('stock');
        return redirect()->route('admin.loans')->with('success', 'Peminjaman disetujui!');
    }

    public function loanReject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $loan->update(['status' => 'rejected']);
        return redirect()->route('admin.loans')->with('success', 'Peminjaman ditolak!');
    }

    private function storeBookCover(UploadedFile $cover): string
    {
        $path = $cover->store('book-covers', 'public');
        BookCoverArchive::mirrorToBackup($path);

        return str_replace('\\', '/', $path);
    }

    private function deleteBookCover(?string $coverPath): void
    {
        if ($coverPath) {
            Storage::disk('public')->delete($coverPath);
        }
    }
}
