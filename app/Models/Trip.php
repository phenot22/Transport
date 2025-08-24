<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'distance', 'cost', 'name', 'address', 'contact', 'schedule', 'transaction_id'];

    protected $attributes = [
        'status' => 'pending',
    ];
}
