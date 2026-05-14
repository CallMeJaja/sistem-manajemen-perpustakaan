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
        return $this->hasOne(Return::class);
    }

    public function isLate(): bool
    {
        return $this->status === 'borrowed' && now()->greaterThan($this->due_date);
    }
}
