<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adventure extends Model
{
    protected $fillable = [
        'guide_id', 'title', 'price', 'description', 'long_description', 'cover_photo'
    ];


    public function photos()
    {
        return $this->belongsToMany('App\File', 'adventures_photos', 'adventure_id', 'file_id');
    }
}
