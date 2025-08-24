<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedTrip extends Model
{
    protected $fillable = [
        'trip_id', 'type', 'distance', 'cost', 'name', 'address', 'contact', 'schedule', 'compname', 'owner_name', 'trucker_name', 'transaction_id'
    ];
}
