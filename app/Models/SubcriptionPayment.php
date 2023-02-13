<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcriptionPayment extends Model
{
    use HasFactory;



        protected $fillable = [
        'user_id',
        'subscription_id',
        'ba_token',
        'token',
        'status',
 
    ];
}
