<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman
     */
    public function index(Request $request)
    {
        $query = Loan::with('book', 'member');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('book', function($bookQuery) use ($search) {
                    $bookQuery->where('title', 'like', '%' . $search . '%');
                })
                ->orWhereHas('member', function($memberQuery) use ($search) {
                    $memberQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Status filtering
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->whereNull('return_date');
                    break;
                case 'returned':
                    $query->whereNotNull('return_date');
                    break;
            }
        }

        // Overdue filtering
        if ($request->has('overdue') && $request->overdue === 'yes') {
            $query->whereNull('return_date')
                  ->where('due_date', '<', now());
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'due_date':
                    $query->orderBy('due_date');
                    break;
                case 'loan_date':
                    $query->orderBy('loan_date', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $loans = $query->paginate(10);
        return view('loans.index', compact('loans'));
    }

    /**
     * Menampilkan form peminjaman buku baru
     */
    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $members = Member::all();
        return view('loans.create', compact('books', 'members'));
    }

    /**
     * Menyimpan peminjaman baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);

        // Cek stok buku
        $book = Book::find($validated['book_id']);
        if ($book->stock <= 0) {
            return redirect()->back()
                ->with('error', 'Stok buku tidak tersedia!');
        }

        // Buat record peminjaman
        Loan::create($validated);

        // Kurangi stok buku
        $book->decrement('stock');

        return redirect()->route('loans.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    /**
     * Form pengembalian buku
     */
    public function returnForm(Loan $loan)
    {
        if (!$loan->isActive()) {
            return redirect()->route('loans.index')
                ->with('error', 'Buku sudah dikembalikan!');
        }
        return view('loans.return', compact('loan'));
    }

    /**
     * Proses pengembalian buku
     */
    public function processReturn(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'return_date' => 'required|date',
        ]);

        // Hitung denda jika terlambat
        $returnDate = Carbon::parse($validated['return_date']);
        $dueDate = Carbon::parse($loan->due_date);
        $fine = 0;

        if ($returnDate->greaterThan($dueDate)) {
            $lateDays = $returnDate->diffInDays($dueDate);
            $fine = $lateDays * 1000; // Rp 1.000 per hari
        }

        // Update peminjaman
        $loan->update([
            'return_date' => $validated['return_date'],
            'fine' => $fine,
        ]);

        // Tambah stok buku kembali
        $loan->book->increment('stock');

        return redirect()->route('loans.index')
            ->with('success', 'Pengembalian buku berhasil dicatat!' . ($fine > 0 ? ' Denda: Rp ' . number_format($fine) : ''));
    }

    /**
     * Hapus record peminjaman
     */
    public function destroy(Loan $loan)
    {
        // Jika belum dikembalikan, kembalikan stoknya
        if ($loan->isActive()) {
            $loan->book->increment('stock');
        }

        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Record peminjaman berhasil dihapus!');
    }
}
