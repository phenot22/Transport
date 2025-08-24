<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'message', 'read_at', 'admin', 'trucker_name', 'email', 'transaction_id' ,'owner_name', 'trucker_name','user_id']; // Add 'user_id' if needed

    public function user()
    {
        return $this->belongsTo(User::class, 'usertype'); // Adjust if your foreign key is different
    }
}