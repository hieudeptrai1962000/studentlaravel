<?php

namespace App\Models\Student;

use App\Models\Faculty\Faculty;
use App\Models\StudentSubject\StudentSubject;
use App\Models\Subject\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Student extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'students';
    protected $fillable = ['full_name', 'email', 'birthday', 'gender','user_id','phone_number', 'image', 'faculty_id','slug'];


    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function students()
    {

        return $this->belongsToMany(Subject::class, 'student_subject')->withPivot('mark');
    }

    public function mark()
    {
        return $this->hasMany(StudentSubject::class,'student_id','id');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'full_name'
            ]
        ];
    }

}
