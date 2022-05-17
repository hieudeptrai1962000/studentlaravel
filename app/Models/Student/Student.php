<?php

namespace App\Models\Student;

use App\Models\Faculty\Faculty;
use App\Models\Studentsubject\Studentsubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['full_name', 'email', 'birthday', 'gender', 'phone_number', 'image', 'faculty_id'];

    public function mark()
    {
        return $this->hasMany(Studentsubject::class,'student_id','id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
