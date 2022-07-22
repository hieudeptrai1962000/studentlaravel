<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UpdateMarkRequest;
use App\Jobs\SendEmail;
use App\Models\Subject\Subject;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class StudentController extends Controller
{
    protected $studentRepo;
    protected $facultyRepo;
    protected $subjectRepo;
    protected $userRepo;

    public function __construct(
        StudentRepositoryInterface $studentRepo,
        FacultyRepositoryInterface $facultyRepository,
        SubjectRepositoryInterface $subjectRepository,
        UsersRepositoryInterface   $userRepo

    )
    {
//        $this->middleware('permission:delete articles per',['only' => ['updatemark','show']]);
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
        $this->subjectRepo = $subjectRepository;
        $this->userRepo = $userRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subjects = $this->subjectRepo->getAll();
        $students = $this->studentRepo->paginate();
        $faculties = $this->facultyRepo->query()->pluck('name', 'id');

        return view('students.index', compact('students', 'subjects', 'faculties'));
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

        if ($request->hasFile('image')) {

            $file = upload('image');
            if (isset($file['name'])) {
                $data['image'] = $file['name'];
            }
        }

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
        $faculty = $this->facultyRepo->getAll();

        return view('students.edit', compact('faculty'));
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
        $faculty = $this->facultyRepo->getAll();

        return view('students.edit', compact('student', 'faculty'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
//        $user = auth()->user();
//        if ($user->hasRole('admin role'))
//        {
        $data = $this->studentRepo->find($id);
        if (Auth::user()->email == $data->email) {

            return redirect()->route('students.index')->with('info', 'Email này đang được sử dụng');
        } else {
            if (Gate::allows('permission', 'admin')) {
                $student = $this->studentRepo->find($id);
                if (!empty($student->image)) {
                    unlink(public_path(url_file($student->image)));
                }
                $this->studentRepo->destroy($id);
                $this->userRepo->destroy($student->user_id);

                return redirect()->route('students.index')->with('success', 'Successfully!');
            }

            return redirect()->route('students.index')->with('warning', 'Permission Denied');
        }
    }

    public function createSubjectAndMark($id)
    {
        $marks = [];
        $subject_ids = [];
        $allSubject = ['' => '--Subject--'] + $this->subjectRepo->getAll()->pluck('name', 'id')->toArray();
        $student = $this->studentRepo->find($id);
        $selectedSubjects = $student->students()->get();

        foreach ($selectedSubjects as $selectedSubject) {
            $marks[] = $selectedSubject->pivot->mark;
            $subject_ids[] = $selectedSubject->pivot->subject_id;
        }

        return view('students.showMark', compact('allSubject', 'student', 'marks', 'subject_ids'));
    }

    public function updateSubjectAndMark(UpdateMarkRequest $request, $id)
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

            $this->studentRepo->find($id)->students()->sync($marks);

            return redirect()->route('students.index')->with('success', 'Successfully !');
        }
        $this->studentRepo->find($id)->students()->detach();

        return redirect()->route('students.index');
    }

    public function searchStudent(SearchRequest $request)
    {
        $subjects = $this->subjectRepo->getAll();
        $students = $this->studentRepo->search($request->all(), $subjects->count());
        $faculties = $this->facultyRepo->query()->pluck('name', 'id');

        return view('students.index', compact('students', 'subjects', 'faculties'));
    }

    public function sendEmail()
    {
        $students = $this->studentRepo->chickenStudent(Subject::all()->count());
        SendEmail::dispatch($students);

        return redirect()->back()->with('success', 'Successfully !');
    }

    public function updateAjax(StudentRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $old_record = $this->studentRepo->find($request->id);
            if (!empty($old_record->image)) {
                unlink(public_path(url_file($old_record->image)));
            }
            $data['image'] = upload('image')['name'];
        } else {
            unset($data['image']);
        }

        $data['slug'] = str_slug($data['full_name']) . '-' . $data['id'];
        unset($data['email']);
        $this->studentRepo->find($request->id)->update($data);
        $student = $this->studentRepo->find($request->id);
        $student->image = asset(url_file($student->image));

        return response()->json($student);
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
            $file_name = $file->move($destinationPath, time() . $file->getClientOriginalName());
        }
        $data['image'] = $file_name;
        $this->studentRepo->find($id)->update($data);

        return redirect()->route('students.index')->with('success', 'Successful!');
    }

    public function showstudents($slug)
    {
        $student = $this->studentRepo->findbyslug($slug);
        return view('students.show', compact('student'));
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


}
