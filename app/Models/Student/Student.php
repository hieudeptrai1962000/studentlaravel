<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['full_name', 'email', 'birthday', 'gender', 'phone_number', 'image', 'faculty_id'];
}
