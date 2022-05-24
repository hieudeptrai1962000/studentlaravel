<?php

namespace App\Models\Faculty;

use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';
    protected $fillable = ['name'];

    public function student()
    {
        return $this->hasMany(Student::class,'faculty_id','id');
    }
}
