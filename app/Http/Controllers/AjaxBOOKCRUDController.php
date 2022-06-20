<?php

namespace App\Http\Controllers;

use App\Models\Student\Student;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AjaxBOOKCRUDController extends Controller
{

    protected $studentRepo;
    protected $facultyRepo;
    protected $subjectRepo;
    protected $markRepo;

    public function __construct(
        StudentRepositoryInterface        $studentRepo,
        FacultyRepositoryInterface        $facultyRepository,
        SubjectRepositoryInterface        $subjectRepository,
        StudentsubjectRepositoryInterface $markRepo

    )
    {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
        $this->subjectRepo = $subjectRepository;
        $this->markRepo = $markRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::orderBy('id','desc')->paginate(5);

        return view('ajax-book-crud',compact('students'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $student = $this->studentRepo->find($request->id)->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'image' => $request->image,
        ]);

        return response()->json($student);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $where = array('id' => $request->id);
//        $book  = Student::where($where)->first();
        $book = $this->studentRepo->query()->where($where)->first();

        return response()->json($book);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Student::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
