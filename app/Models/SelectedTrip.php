<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id', 'type', 'distance', 'cost', 'name', 'address', 'contact', 'schedule', 'compname', 'owner_name', 'transaction_id'
    ];
    
    protected $attributes = [
        'status' => 'pending',
    ];
}


