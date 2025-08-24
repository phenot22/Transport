<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trucker extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural form of the model
    protected $table = 'users';

    // Define the fillable fields to allow mass assignment
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

    // If you're using timestamps, you don't need to do anything else, but you can disable them like this:
    // public $timestamps = false;
}
