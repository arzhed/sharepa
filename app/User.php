<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'photo', 'short_bio', 'long_bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isGuide()
    {
        return $this->role === 'guide';
    }

    public function isTraveler()
    {
        return $this->role === 'traveler';
    }

    public function isRegistrationOver() {
        if ($this->isGuide()) {
            return !is_null($this->short_bio) && !is_null($this->long_bio);
        } else if ($this->isTraveler()) {
            return !is_null($this->short_bio);
        }
        return true; //ADMIN
    }

    public function adventures() {
        return $this->hasMany('App\Adventure', 'guide_id', 'id');
    }

    public function files() {
        return $this->hasMany('App\File', 'user_id', 'id');
    }

    public function photo() {
        return $this->hasOne('App\File', 'id', 'photo');
    }

}
