<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'landlord_id',
        'first_name',
        'last_name',
        'email',        
        'contact_no',
        'address',
        'valid_id',
        'status',
    ];
}
