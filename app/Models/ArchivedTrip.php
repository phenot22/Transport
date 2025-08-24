<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedTrip extends Model
{
    use HasFactory;

    protected $table = 'archived_trips'; // Ensure the correct table name

    protected $fillable = [
        'type', 'distance', 'cost', 'name', 'address', 'contact', 'schedule', 'status', 'updated_at', 'created_at', 'transaction_id'
    ];

    // Set default attributes
    protected $attributes = [
        'status' => 'pending',
    ];
}
