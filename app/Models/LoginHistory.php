<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'login_time',
        'logout_time', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
