<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'no_telp', 'address', 'user_id', 'image', 'date_of_birth', 'nuptk', 'gender'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function monitoredStudents()
    {
        return $this->belongsToMany(Student::class, 'student_teacher');
    }

}
