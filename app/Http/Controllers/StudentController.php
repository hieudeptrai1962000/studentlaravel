<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student\Student;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $userId = $this->userRepo->find(Auth::id())->student;
        $subjects = $this->subjectRepo->getAllList();
        $students = $this->studentRepo->paginate();
        $faculties = $this->facultyRepo->query()->pluck('name','id');
        return view('students.index', compact('students', 'subjects','faculties','userId'))->with('i');
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
            $file_name = $file->move('uploads', $file->getClientOriginalName());
//            dd($file_name);

        }
        $data['image'] = $file_name;
        $this->studentRepo->store($data);
        return redirect()->route('students.index')->with('success', 'Successful!');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $faculty = $this->facultyRepo->getAllList();
        return view('students.edit', compact('faculty'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {


            $student = $this->studentRepo->find($id);
            $done = $student->stu;
            $all = $this->subjectRepo->getAllList();
            $diff = $all->diff($done);
//        dd($done);
//        $diff = $subject->diff($done);
//
//        $data = [];
//        foreach ($diff as $value) {
//            array_push($data, [
//                'subject_id' => $value->id,
//                'mark' => 0,
//            ]);
//        }
//
//        $marks = [];
//        foreach ($data as $key => $value) {
//            $marks[$value['subject_id']] = ['mark' => $value['mark']];
//        }
//        $this->studentRepo->find($id)->stu()->syncWithoutDetaching($marks);
//        $persubject = DB::table('student_subject')
//            ->join('students', 'student_id', '=', 'students.id')
//            ->join('subjects', 'subject_id', '=', 'subjects.id')
//            ->where('student_id', $id)
//            ->get();

            return view('students.showMark', compact('diff','done','all','student'));


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
        return view('students.edit', compact('student', 'faculty'));
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

        return redirect()->route('students.index')->with('success', 'Successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

//        if(Gate::allows('permission','admin'))
//        {
//            $this->studentRepo->destroy($id);
//
//            return redirect()->route('students.index')->with('success', 'Successfully!');
//        }
//
//        return redirect()->route('students.index')->with('success', 'Nope!');

//        $user = auth()->user();
//        if ($user->hasRole('admin role'))
//        {
            $this->studentRepo->destroy($id);

            return redirect()->route('students.index')->with('success', 'Successfully!');
//        }
//
//        else
//        {
//            return redirect()->route('students.index')->with('success', 'Nope!');
//        }

    }

//    public function addsubject($id)
//    {
//        $subject = $this->subjectRepo->getAllList();
//        $student = $this->studentRepo->find($id);
//        return view('students.updatesubject', compact('student', 'subject'));
//    }
//
//    public function updatesubject(Request $request)
//    {
//        $student_id = $request->input('student_id');
//        $this->studentRepo->find($student_id)->stu()->sync($request->subject_id);
//
//        return redirect()->route('students.index')->with('success', 'Successfully !');
//    }
//
//    public function addmark(Request $request, $id)
//    {
//        $student = $this->studentRepo->find($id);
////        $mark = $this->markRepo->find($id);
//        $subject = $this->subjectRepo->getAllList();
////        $subject = $this->subjectRepo->getAllList();
//        $user= DB::table('student_subject')
//            ->join('subjects', 'student_subject.subject_id', '=', 'subjects.id')
//            ->join('students','student_subject.student_id','=','students.id')
//            ->get()->where('id',$id);
//
//        return view('students.addMark', compact('user','subject','student'));
//
//    }

    public function updatemark(Request $request, $id)
    {
        if (isset($request->subject_id)) {
            $data = [];
            foreach ($request->subject_id as $elden => $value) {
                array_push($data, [
                    'subject_id' => $request->subject_id[$elden],
                    'mark' => $request->mark[$elden],
                ]);
            }
            $marks = [];
            foreach ($data as $key => $value) {
                $marks[$value['subject_id']] = ['mark' => $value['mark']];
            }

            $this->studentRepo->find($id)->stu()->sync($marks);

            return redirect()->route('students.index')->with('success', 'Successfully !');
        }
        else
        {
            $this->studentRepo->find($id)->stu()->detach();

            return redirect()->route('students.index');
        }
    }

    public function showAjax($id)
    {
//       $student = $this->studentRepo->find($id);
//        $this->facultyRepo->getAllList();
//
//       return response()->json($student);
    }

    public function updateAjax(Request $request, $id)
    {
//        $student = $this->studentRepo->find($id);
        ;
//        if ($request->has('image')) {
//            $file = $request->file('image');
//            $destinationPath = 'uploads';
//            $file_name = $file->move($destinationPath, $file->getClientOriginalName());
//        }
//        $data['image'] = $file_name;
        $student = $this->studentRepo->find($id)->update([
            'full_name' => $request->id,
        ]);
        dd($student);
        return response()->json($student);
    }

    public function showstudents($id , $slug)
    {
        $students = $this->studentRepo->query()
            ->where('id',$id)
            ->where('slug',$slug)
            ->get();
        return view('students.show',compact('students'));
    }

}
