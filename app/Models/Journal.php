<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['image','title','description','student_id'];

    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
}
