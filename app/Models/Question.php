<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'first_choice',
        'second_choice',
        'third_choice',
        'fourth_choice',
        'answer',
        'description',
        'status',
    ];
}
