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

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
