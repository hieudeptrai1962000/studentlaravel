<?php

namespace App\Http\Controllers;

use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $studentRepo;
    protected $userRepo;

    public function __construct(
        StudentRepositoryInterface $studentRepo,
        UsersRepositoryInterface   $userRepo
    )
    {
        $this->studentRepo = $studentRepo;
        $this->userRepo = $userRepo;
    }


    public function callback($social)
    {
        $user = Socialite::driver($social)->user();
        $student = $this->userRepo->query()->where('email', $user->getEmail())->first();

        if (empty($student)) {
            $newUser = $this->userRepo->store(
                [
                    'username' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => '123456789',
                    'permission' =>'user',
                    'providerID' => $user->getId(),
                ]
            );
            $newStudent = $this->studentRepo->store([
                'full_name' => $user->getName(),
                'email' => $user->getEmail(),
                'birthday' => Carbon::now(),
                'user_id' => $newUser->id,
            ]);
            Auth::loginUsingId($newUser->id);

            return redirect()->route('show-student',$newStudent->slug);
        }
        $studentInfor = $this->studentRepo->query()->where('email',$user->getEmail())->first();
        $this->userRepo->query()->find($student->id)->update([
            'providerID' => $user->getId(),
        ]);
        Auth::loginUsingId($student->id);

        return redirect()->route('show-student',$studentInfor->slug);
    }

    public function login($social)
    {
        return Socialite::driver($social)->redirect();
    }

}

