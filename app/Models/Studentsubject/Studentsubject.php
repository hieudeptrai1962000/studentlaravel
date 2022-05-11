<?php

namespace App\Models\Studentsubject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentsubject extends Model
{
    use HasFactory;

    protected $table = 'student_subject';
    protected $fillable = ['student_id', 'subject_id', 'mark'];
}
