<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $markRepo;
    protected $userRepository;

    public function __construct(
        UsersRepositoryInterface  $usersRepository,
        StudentRepositoryInterface        $studentRepo,
        FacultyRepositoryInterface        $facultyRepository,
        SubjectRepositoryInterface        $subjectRepository,
        StudentsubjectRepositoryInterface $markRepo

    )
    {
        $this->userRepository = $usersRepository;
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
        $this->subjectRepo = $subjectRepository;
        $this->markRepo = $markRepo;
        $this->middleware('guest');
    }


   public function RegisterNewUser(RegisterRequest $request)
   {

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = $this->userRepository->store($data);

       if ($request->has('image')) {
           $file = $request->file('image');
           $file_name = $file->move('uploads', $file->getClientOriginalName());
       }

       $data['image'] = $file_name;
       $data['user_id'] = $user->id;

       $this->studentRepo->store($data);

       $credentials = $request->only('email', 'password');
       if (Auth::attempt($credentials)) {
           $data = $this->userRepository->find(Auth::id())->student;
           $slug = $data->slug;
           $userId = $data->id;
           return redirect()->route('show.students',[$userId, $slug]);
       }

       return redirect('register')->with('warning','Something is incorrect')->withInput();
   }
}
