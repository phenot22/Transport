<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'users';  

    protected $fillable = [
        'compname',
        'email',
        'company_phone',
           'company_address',
            'owner_name',
             'owner_email',
              'owner_phone', 
              'trucker_name', 
               'gender', 
               'dob', 
               'trucker_address', 
               'trucker_phone'
    ];

    
    
}
