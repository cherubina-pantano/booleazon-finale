<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Mass assign
    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'path_img'
    ];

    //DB Relations
    //sizes - products
    public function sizes() {
        return $this->belongsToMany('App\Size');
    }
    //stockpiles - products
    public function stockpiles() {
        return $this->belongsToMany('App\Stockpile');
    }
}

