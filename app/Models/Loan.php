<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'loan_date',
        'loaned_at',
        'return_date',
        'returned_at',
        'due_date',
        'due_at',
        'fine',
        'status',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'loaned_at' => 'datetime',
        'return_date' => 'date',
        'returned_at' => 'datetime',
        'due_date' => 'date',
        'due_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Relasi: Loan milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Loan milik satu Book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relasi: Loan milik satu Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Hitung denda otomatis (Rp 1.000 per hari keterlambatan)
     */
    public function calculateFine()
    {
        if ($this->returned_at_local && $this->due_at_local) {
            $returnDate = $this->returned_at_local;
            $dueDate = $this->due_at_local;

            if ($returnDate->greaterThan($dueDate)) {
                $lateDays = $returnDate->diffInDays($dueDate);
                return $lateDays * 1000; // Rp 1.000 per hari
            }
        }
        return 0;
    }

    /**
     * Cek apakah peminjaman masih aktif (belum dikembalikan)
     */
    public function isActive()
    {
        return is_null($this->return_date);
    }

    /**
     * Cek apakah peminjaman terlambat
     */
    public function isOverdue()
    {
        if ($this->isActive()) {
            return Carbon::now()->greaterThan($this->due_at_local);
        }
        return false;
    }

    public function getLoanedAtLocalAttribute(): ?Carbon
    {
        if ($this->loaned_at) {
            return $this->loaned_at->copy();
        }

        if ($this->loan_date) {
            $fallbackTime = $this->created_at instanceof Carbon
                ? $this->created_at->format('H:i:s')
                : '00:00:00';

            return Carbon::parse($this->loan_date->format('Y-m-d') . ' ' . $fallbackTime);
        }

        return null;
    }

    public function getDueAtLocalAttribute(): ?Carbon
    {
        if ($this->due_at) {
            return $this->due_at->copy();
        }

        if ($this->due_date) {
            $time = $this->loaned_at_local?->format('H:i:s') ?? '23:59:59';

            return Carbon::parse($this->due_date->format('Y-m-d') . ' ' . $time);
        }

        return null;
    }

    public function getReturnedAtLocalAttribute(): ?Carbon
    {
        if ($this->returned_at) {
            return $this->returned_at->copy();
        }

        if ($this->return_date) {
            $fallbackTime = $this->updated_at instanceof Carbon
                ? $this->updated_at->format('H:i:s')
                : '00:00:00';

            return Carbon::parse($this->return_date->format('Y-m-d') . ' ' . $fallbackTime);
        }

        return null;
    }
}
