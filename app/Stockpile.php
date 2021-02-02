<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockpile extends Model
{
    //Mass assign
    protected $fillable = [
        'product_id',
        'stockpile',
        'available',
    ];
     /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;
    /**
     * DB RELATIONS
     */
    //stockpiles - products
    public function product() {
        return $this->belongsTo('App\Product');
    }
}
