<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\StudentSubject\Studentsubject;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $student = $this->studentRepo->paginate();
        return view('student.main', compact('student'))->with('i');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StudentRequest $request)
    {

        $data = $request->all();
        if ($request->has('image')) {
            $file = $request->file('image');
            $file_name = $file->move('uploads', $file->getClientOriginalExtension());
//            dd($file_name);

        }
        $data['image'] = $file_name;
        $this->studentRepo->store($data);
        return redirect()->route('student.index')->with('success', 'Successful!');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $faculty = $this->facultyRepo->getAllList();
        return view('student.edit', compact('faculty'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $student = $this->studentRepo->find($id);
        $faculty = $this->facultyRepo->getAllList();
        return view('student.edit', compact('student', 'faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(StudentRequest $request, $id)
    {
        $data = $request->all();
        if ($request->has('image')) {
            $file = $request->file('image');
            $destinationPath = 'uploads';
            $file_name = $file->move($destinationPath, $file->getClientOriginalName());
        }
        $data['image'] = $file_name;
        $this->studentRepo->find($id)->update($data);

        return redirect()->route('student.index')->with('success', 'Successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->studentRepo->destroy($id);
        return redirect()->route('student.index')->with('success', 'Successfully!');
    }

    public function addsubject($id)
    {
        $subject = $this->subjectRepo->getAllList();
        $student = $this->studentRepo->find($id);
        return view('student.updatesubject', compact('student', 'subject'));
    }

    public function updatesubject(Request $request)
    {
        $student_id = $request->input('student_id');
        $subject = $request->input('subject_id');
        $mark = $request->input('mark');
        foreach ($subject as $s) {
            $result = new Studentsubject;
            $result->student_id = $student_id;
            $result->subject_id = $s;
            $result->mark = $mark;
            $result->save();
        }
        return redirect()->route('student.index')->with('success', 'Successfully !');
    }

    public function addmark($id)
    {
        $mark = $this->markRepo->query()->where('student_id', $id)->get();
        return view('student.updatemark', compact('mark'));
    }

    public function updatemark(Request $request)
    {
        $mark_id = $request->input('mark_id');
        $this->markRepo->find($mark_id)->update($request->all());
        return redirect()->route('student.index')->with('success', 'Successfully !');
    }
}
