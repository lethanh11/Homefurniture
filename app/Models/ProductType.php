<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'producttype';

    protected $fillable = [
        'Category_id','name','slug','status',
    ];

    public function Category(){
        return $this->belongsTo('App\Models\Category','Category_id','id');
    }
}
