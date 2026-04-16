<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function books()
    {
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    public function booksCreate()
    {
        return view('books.create');
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
        ]);

        Book::create($request->all());
        return redirect()->route('admin.books')->with('success', 'Buku ditambahkan!');
    }

    public function booksEdit(Book $book)
    {
        return view('books.edit', compact('book'));
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
        ]);

        $book->update($request->all());
        return redirect()->route('admin.books')->with('success', 'Buku diperbarui!');
    }

    public function booksDestroy(Book $book)
    {
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
}

