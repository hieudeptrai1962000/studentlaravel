<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


    public function callback($social, Request $request)
    {
        $user = Socialite::driver($social)->user();
        $userEmail = User::where('email', '=', $user->getEmail())->first();

        if (empty($userEmail)) {
            $newUser = $this->userRepo->store(
                [
                    'username' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getId()),
                ]
            );

            $this->studentRepo->store(
                [
                    'full_name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'birthday' => Carbon::now(),
                    'user_id' => $newUser->id
                ]
            );

            $data = [
                'email' => $user->getEmail(),
                'password' => $user->getId(),
            ];

            if (Auth::attempt($data)) {

                return redirect()->route('students.index')->with('success', 'Successful!');
            } else {

                return redirect('login')->with('warning', 'Email hoặc mật khẩu đã được sử dụng')->withInput();
            }
        } else {
            $data = [
                'email' => $user->getEmail(),
                'password' => $user->getId(),
            ];

            if (Auth::attempt($data)) {

                return redirect()->route('students.index')->with('success', 'Successful!');
            } else {

                return redirect('login')->with('warning', 'Email hoặc mật khẩu đã được sử dụng')->withInput();
            }
        }
    }

    public function login($social)
    {
        return Socialite::driver($social)->redirect();
    }

}

