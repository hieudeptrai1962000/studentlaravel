<?php

namespace App\Models;

use App\Models\Student\Student;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;

class   User extends Authenticatable
{
    use Notifiable, HasRoles;
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'username','email', 'password','permission','slug','providerID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function hasDefinePrivilege($permission)
    {
        if (!$permission) {
            return false;
        }

        return $this->permission ==  $permission;
    }

    public function student()
    {
        return $this->hasOne(Student::class,'user_id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'username'
            ]
        ];
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
