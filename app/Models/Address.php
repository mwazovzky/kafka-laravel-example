<?php

namespace App\Models;

use App\Enums\AddressStatus;
use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status',
        'hash',
        'chain_id',
        'client_id',
    ];

    protected $casts = [
        'type' => AddressType::class,
        'status' => AddressStatus::class,
    ];

    public function chain(): BelongsTo
    {
        return $this->belongsTo(Chain::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
