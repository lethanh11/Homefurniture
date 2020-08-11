<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name','slug','description','quantity','price','promotional','Category_id','ProductType_id','image','status',
    ];

    public function ProductType(){
        return $this->belongsTo('App\Models\ProductType','ProductType_id','id');
    }

    public function Category(){
        return $this->belongsTo('App\Models\Category','Category_id','id');
    }
}
