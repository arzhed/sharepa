<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adventure extends Model
{
    protected $fillable = [
        'guide_id', 'title', 'price', 'description', 'long_description'
    ];
}
