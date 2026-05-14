<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $memberNumber = 'MBR-' . str_pad(Member::count() + 1, 5, '0', STR_PAD_LEFT);

        return view('members.create', compact('memberNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_number' => ['required', 'string', 'max:20', 'unique:members,member_number'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:members,email'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'join_date'     => ['required', 'date'],
        ]);

        Member::create($request->only(['member_number', 'name', 'email', 'phone', 'address', 'join_date']));

        return redirect()->route('members.index')->with('success', 'Anggota berhasil didaftarkan.');
    }

    public function show(Member $member)
    {
        return redirect()->route('members.edit', $member);
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'member_number' => ['required', 'string', 'max:20', 'unique:members,member_number,' . $member->id],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:members,email,' . $member->id],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'join_date'     => ['required', 'date'],
        ]);

        $member->update($request->only(['member_number', 'name', 'email', 'phone', 'address', 'join_date']));

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->hasActiveBorrowing()) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
