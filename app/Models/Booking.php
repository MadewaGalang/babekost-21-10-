<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    // Status yang masih "menahan" kamar pada rentang tanggalnya.
    public const ACTIVE_STATUSES = ['menunggu_pembayaran', 'booking', 'aktif'];

    protected $fillable = [
        'tenant_id', 'room_id', 'package',
        'start_date', 'end_date',
        'total_price', 'deposit_amount',
        'status', 'house_rules_agreed_at',
        'cancelled_at', 'cancellation_reason',
        'cleaned_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'integer',
            'deposit_amount' => 'integer',
            'house_rules_agreed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'cleaned_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /** Tanggal pembersihan kamar: H+1 setelah masa sewa berakhir. */
    protected function cleaningDate(): Attribute
    {
        return Attribute::get(fn () => $this->end_date?->copy()->addDay());
    }
}