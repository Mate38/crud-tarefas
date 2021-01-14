<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $fillable = [
        'displayName', 
        'email', 
        'localId',
    ];

    public function getAuthIdentifierName() {
        return 'localId';
    }

    public function getAuthIdentifier(){
        return $this->localId;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function setFakeUser() {
        $user = new self([
            'displayName' => 'TestUser',
            'email' => 'test@test.com',
            'localId' => 'm280TBpG2Mgpt5nNMQF7REhLBRQ2'
        ]);
        Auth::login($user);
        return $user;
    }

}
