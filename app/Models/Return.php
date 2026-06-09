<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Return extends Model
{
    /** @use HasFactory<\Database\Factories\ReturnFactory> */
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'borrowing_id',
        'return_date',
        'late_days',
        'fine_amount',
        'notes',
    ];

    protected $casts = [
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
