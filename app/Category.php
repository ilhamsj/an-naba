<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function Articles()
    {
        return $this->hasMany('App\Articles');
    }
}
