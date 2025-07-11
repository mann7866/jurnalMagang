<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','no_telp','address','user_id','image'];

    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }
}
