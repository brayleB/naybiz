<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileupload extends Model
{
    use HasFactory;


    protected $fillable = [
        'hoa_id',
        'path',
        'status',
    ];
}
