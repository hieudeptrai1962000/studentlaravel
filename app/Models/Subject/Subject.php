<?php

namespace App\Models\Subject;

use App\Models\Studentsubject\Studentsubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $fillable = ['name'];

    public function mark()
    {
        return $this->hasMany(Studentsubject::class,'subject_id','id');
    }
}
