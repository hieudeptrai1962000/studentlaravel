<?php

namespace App\Models\Student;

use App\Models\Faculty\Faculty;
use App\Models\Studentsubject\Studentsubject;
use App\Models\Subject\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    public function stu()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }
}
