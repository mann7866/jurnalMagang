<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['image','title','description','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
