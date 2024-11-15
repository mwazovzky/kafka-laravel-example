<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'chain_currency_id');
    }
}
