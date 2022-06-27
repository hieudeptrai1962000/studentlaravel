<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student\Student;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{

    protected $studentRepo;
    protected $facultyRepo;
    protected $subjectRepo;
    protected $markRepo;
    protected $userRepo;

    public function __construct(
        StudentRepositoryInterface        $studentRepo,
        FacultyRepositoryInterface        $facultyRepository,
        SubjectRepositoryInterface        $subjectRepository,
        StudentsubjectRepositoryInterface $markRepo,
        UsersRepositoryInterface          $userRepo

    )
    {
//        $this->middleware('permission:delete articles per',['only' => ['updatemark','show']]);
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
        $this->subjectRepo = $subjectRepository;
        $this->markRepo = $markRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = $this->studentRepo->getAllList();

        return ProductResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return Student::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student\  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->studentRepo->find($id);

        return new ProductResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student\  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         Student::find($id)->update($request->all());

        return redirect()->route('superproducts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student\  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return  $this->studentRepo->destroy($id);
    }
}
