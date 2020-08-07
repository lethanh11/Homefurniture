<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'User_id','address','phone',
    ];

    public function User(){
        return $this->belongsTo('App\Models\User','User_id','id');
    }
}
