<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar semua anggota
     */
    public function index(Request $request)
    {
        $query = Member::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'name':
                    $query->orderBy('name');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Filter active members (those with active loans)
        if ($request->has('active') && $request->active === 'yes') {
            $query->whereHas('loans', function($q) {
                $q->whereNull('return_date');
            });
        }

        $members = $query->paginate(10);
        return view('members.index', compact('members'));
    }

    /**
     * Menampilkan form tambah anggota
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Menyimpan anggota baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail anggota
     */
    public function show(Member $member)
    {
        $loans = $member->loans()->with('book')->get();
        return view('members.show', compact('member', 'loans'));
    }

    /**
     * Menampilkan form edit anggota
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update data anggota
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil diperbarui!');
    }

    /**
     * Hapus anggota
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}
