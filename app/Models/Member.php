<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'email',
        'phone',
        'address',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function hasActiveBorrowing(): bool
    {
        return $this->borrowings()->where('status', 'borrowed')->exists();
    }
}
