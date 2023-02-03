<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteTrasaction extends Model
{
    use HasFactory;


     protected $fillable = [
        'payerid',
        'token',

    ];
}
