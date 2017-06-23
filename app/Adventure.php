<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adventure extends Model
{
    protected $fillable = [
        'guide_id', 'title', 'price', 'description', 'long_description', 'cover_photo'
    ];


    public function files()
    {
        return $this->belongsToMany('App\File', 'adventures_photos', 'adventure_id', 'file_id');
    }

    public function cover() {
        return $this->hasOne('App\File', 'id', 'cover_photo');
    }

    public function guide() {
        return $this->hasOne('App\User', 'id', 'guide_id');
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update($attributes, $options);

        $this->files()->sync($attributes['files']);
    }
}
