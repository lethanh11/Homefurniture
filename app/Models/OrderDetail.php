<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetail';

    protected $fillable = [
        'Order_id','Product_id','quantity','price',
    ];

    public function Order(){
        return $this->belongsTo('App\Models\Order','Order_id','id');
    }

    public function Product(){
        return $this->belongsTo('App\Models\Product','Product_id','id');
    }

}
