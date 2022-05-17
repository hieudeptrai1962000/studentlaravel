<?php

namespace App\Models\Studentsubject;

use App\Models\Student\Student;
use App\Models\Subject\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentsubject extends Model
{
    use HasFactory;

    protected $table = 'student_subject';
    protected $fillable = ['student_id', 'subject_id', 'mark'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
