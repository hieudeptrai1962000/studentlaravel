<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    protected $studentRepo;
    protected $facultyRepo;
    protected $subjectRepo;
    protected $userRepository;

    public function __construct(
        UsersRepositoryInterface   $usersRepository,
        StudentRepositoryInterface $studentRepo,
        FacultyRepositoryInterface $facultyRepository,
        SubjectRepositoryInterface $subjectRepository
    )
    {
        $this->userRepository = $usersRepository;
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
        $this->subjectRepo = $subjectRepository;
        $this->middleware('guest');
    }

    public function RegisterUser(RegisterRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository->store($data);
        $data['image'] = upload('image')['name'];
        $data['user_id'] = $user->id;
        $student = $this->studentRepo->store($data);
        Auth::loginUsingId($user->id);

        return redirect()->route('show-student',$student->slug);
   }
}
