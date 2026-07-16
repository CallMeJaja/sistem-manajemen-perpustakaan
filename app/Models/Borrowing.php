<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowingFactory> */
    use HasFactory;

    protected $fillable = [
        'borrow_number',
        'member_id',
        'book_id',
        'borrow_date',
        'due_date',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date'    => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function return()
    {
        return $this->hasOne(BookReturn::class, 'borrowing_id');
    }

    public function isLate(): bool
    {
        return $this->status === 'borrowed' && now()->greaterThan($this->due_date);
    }

    /**
     * Nomor transaksi berurutan harian: PJ/YYYYMMDD/0001
     */
    public static function generateBorrowNumber(): string
    {
        $prefix = 'PJ/' . now()->format('Ymd') . '/';
        $count = static::where('borrow_number', 'like', $prefix . '%')->count();

        return $prefix . str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}

