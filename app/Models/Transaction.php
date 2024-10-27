<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'status',
        'txid',
        'vout',
        'address_id',
        'chain_id',
        'currency_id',
        'amount',
        'fee_currency_id',
        'fee_amount',
    ];

    protected $casts = [
        'type' => TransactionType::class,
        'status' => TransactionStatus::class,
    ];

    public function chain(): BelongsTo
    {
        return $this->belongsTo(Chain::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function feeCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'fee_currrency_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function operation()
    {
        return $this->hasOneThrough(
            Operation::class,
            OperationTransaction::class,
            'transaction_id',
            'id',
            'id',
            'operation_id',
        );
    }
}
