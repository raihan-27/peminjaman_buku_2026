<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function dashboard()
    {
        $userId = Session::get('user.id');
        $role = Session::get('user.role');
        $books = Book::count();
        $pendingLoans = Loan::where('user_id', $userId)->where('status', 'pending')->count();
        $activeLoans = Loan::where('user_id', $userId)->whereNull('return_date')->where('status', 'approved')->count();
        $pendingApprovals = $role === 'admin'
            ? Loan::where('status', 'pending')->count()
            : 0;

        return view('dashboard', compact('books', 'pendingLoans', 'activeLoans', 'pendingApprovals'));
    }

    public function books()
    {
        $books = Book::orderBy('title')->get();
        return view('buku', compact('books'));
    }

    public function requestBorrow()
    {
        $books = Book::where('stock', '>', 0)->orderBy('title')->get(['id', 'title', 'stock']);
        return view('peminjaman', compact('books'));
    }

    public function storeRequestBorrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);

        $currentTime = now();
        $loanedAt = Carbon::parse($request->loan_date . ' ' . $currentTime->format('H:i:s'));
        $dueAt = Carbon::parse($request->due_date . ' ' . $loanedAt->format('H:i:s'));

        Loan::create([
            'book_id' => $request->book_id,
            'user_id' => Session::get('user.id'),
            'loan_date' => $loanedAt,
            'loaned_at' => $loanedAt,
            'due_date' => $dueAt,
            'due_at' => $dueAt,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Permintaan peminjaman dikirim! Menunggu persetujuan admin.');
    }

    public function returns()
    {
        $userId = Session::get('user.id');
        $activeLoans = Loan::with('book')->where('user_id', $userId)->whereNull('return_date')->where('status', 'approved')->latest()->get();
        return view('pengembalian', compact('activeLoans'));
    }

    public function processReturn(Request $request, Loan $loan)
    {
        $userId = Session::get('user.id');
        if ($loan->user_id != $userId || $loan->status != 'approved' || $loan->return_date) {
            return back()->with('error', 'Tidak diizinkan mengembalikan buku ini.');
        }

        $returnedAt = now();
        $lateDays = $loan->due_at_local && $loan->due_at_local->lt($returnedAt)
            ? $returnedAt->diffInDays($loan->due_at_local)
            : 0;
        $fine = $lateDays * 1000;

        $loan->update([
            'return_date' => $returnedAt,
            'returned_at' => $returnedAt,
            'fine' => $fine,
        ]);

        $loan->book->increment('stock');

        return redirect()->route('dashboard')->with('success', 'Buku dikembalikan! Denda: Rp ' . number_format($fine));
    }

    public function profile()
    {
        $user = User::with(['loans.book'])
            ->findOrFail(Session::get('user.id'));

        $profileStats = [
            'total_loans' => $user->loans->count(),
            'pending_loans' => $user->loans->where('status', 'pending')->count(),
            'active_loans' => $user->loans->where('status', 'approved')->whereNull('return_date')->count(),
            'returned_loans' => $user->loans->whereNotNull('return_date')->count(),
        ];

        $recentLoans = $user->loans
            ->sortByDesc(fn (Loan $loan) => $loan->loaned_at_local ?? $loan->created_at)
            ->take(5)
            ->values();

        return view('profile', compact('user', 'profileStats', 'recentLoans'));
    }
}

