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
        $books = Book::where('stock', '>', 0)->orderBy('title')->get(['id', 'title', 'author', 'category', 'stock', 'cover_path']);
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
        $user = User::findOrFail(Session::get('user.id'));

        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Session::get('user.id');
        $user = User::findOrFail($userId);

        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture) {
                $oldPath = storage_path('app/public/profile-pictures/' . $user->profile_picture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Simpan foto baru
            $file = $request->file('profile_picture');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile-pictures', $filename, 'public');

            $user->update(['profile_picture' => $filename]);
            
            // Refresh user dari database
            $user->refresh();
            
            // Update session dengan profile_picture terbaru
            $userSession = session('user');
            $userSession['profile_picture'] = $filename;
            session(['user' => $userSession]);
        }

        // Return view dengan user terbaru untuk immediate feedback
        return view('profile', compact('user'))->with('success', 'Foto profil berhasil diperbarui!');
    }
}

