<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assoc_hoa_id',
        'username',
        'email',
        'password',
        'type',
        'status',
        'image',
        'first_name',
        'last_name',
        'contact_no',
        'address',
        'city',
        'state',
        'country',
        'ba_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $email = $this->email;
        $link = route('password.reset', ['token' => $token]);
        Mail::to($email)->send(new ResetPassword($link));
    }



       public function Properties(){
        return $this->hasMany('App\Models\Property', 'landlord_id', 'id')->where('status','active');
    }

 
}