<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rental_id',
        'receipt_number',
        'type',
        'amount',
        'paid_at',
        'destination_account',
        'proof_path',
        'status',
        'rejection_reason',
        'verified_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}
