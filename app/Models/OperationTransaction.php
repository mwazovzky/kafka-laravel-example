<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'operation_id',
        'transaction_id',
    ];
}
