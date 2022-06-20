<?php

namespace App\Http\Controllers;

use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class AjaxController extends Controller
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
        $subjects = $this->subjectRepo->getAllList();
        $students = $this->studentRepo->paginate();
        return view('students.editajax',compact('students','subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if ($request->has('image')) {
            $file = $request->file('image');
            $destinationPath = 'uploads';
            $file_name = $file->move($destinationPath, $file->getClientOriginalName());
        }
        $data['image'] = $file_name;
        $this->studentRepo->find($id)->update($data);

        return redirect()->route('students.index')->with('success', 'Successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
