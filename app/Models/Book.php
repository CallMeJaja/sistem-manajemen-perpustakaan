<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_image',
        'author',
        'publisher',
        'isbn',
        'category',
        'year',
        'total_stock',
        'available_stock',
        'location',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
