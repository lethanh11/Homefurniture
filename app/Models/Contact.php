<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'User_id','message',
    ];

    public function User(){
        return $this->belongsTo('App\Models\User','User_id','id');
    }
}
