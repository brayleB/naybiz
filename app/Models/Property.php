<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hoa_id',
        'landlord_id',
        'tenant_id',
        'address',
        'image',
        'price',
        'status',
    ];
    
}
