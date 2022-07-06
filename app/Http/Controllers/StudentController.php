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
use Illuminate\Filesystem\Filesystem;
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
        $faculties = $this->facultyRepo->query()->pluck('name','id');
        $username = Auth::user()->username;


        return view('students.index', compact('students', 'subjects', 'faculties','username'));
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
        $faculty = $this->facultyRepo->getAll();
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
            $file_name = $file->move($destinationPath, time() . $file->getClientOriginalName());
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
//        $user = auth()->user();
//        if ($user->hasRole('admin role'))
//        {
        if (Gate::allows('permission', 'admin')) {
            $student = $this->studentRepo->find($id);
            if (!empty($student->image)) {
                unlink(public_path(url_file($student->image)));
                $FileSystem = new Filesystem();
                $linkFolder = public_path().'/uploads/'.date('Y/m/d/');
                if ($FileSystem->exists($linkFolder)) {
                    // Get all files in this directory.
                    $files = $FileSystem->files($linkFolder);
                    // Check if directory is empty.
                    if (empty($files)) {
                        // Delete the directory.
                        $FileSystem->deleteDirectory($linkFolder);
                    }
                }
            }
            $this->studentRepo->destroy($id);

            return redirect()->route('students.index')->with('success', 'Successfully!');
        }

        return redirect()->route('students.index')->with('warning', 'Permission Denied  ');
    }

    public function createSubjectAndMark($id)
    {
        $student = $this->studentRepo->find($id);
        $subjectDones = $student->students;
        $allSubject = $this->subjectRepo->getAll();

        return view('students.showMark', compact('subjectDones', 'allSubject', 'student'));
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
        } else {
            $this->studentRepo->find($id)->students()->detach();

            return redirect()->route('students.index');
        }
    }

    public function searchStudent(SearchRequest $request)
    {
        $subjects = $this->subjectRepo->getAll();
        $students = $this->studentRepo->search($request->all(), Subject::all()->count());
        $faculties = $this->facultyRepo->query()->pluck('name', 'id');

        return view('students.index', compact('students', 'subjects', 'faculties'));
    }

    public function sendEmail()
    {
        $students = $this->studentRepo->chickenStudent(Subject::all()->count());
        SendEmail::dispatch($students);
        return redirect()->back();
    }


    public function updateAjax(StudentRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $old_record = $this->studentRepo->find($request->id);
            if (!empty($old_record->image)) {
                unlink(public_path(url_file($old_record->image)));
            }

            $file = upload('image');
            if (isset($file['name'])) {
                $data['image'] = $file['name'];
            }
        } else {
            unset($data['image']);
        }

        $data['slug'] = str_slug($data['full_name']);
        unset($data['email']);
        $this->studentRepo->find($request->id)->update($data);
        $student = $this->studentRepo->find($request->id);
        $student->image = asset(url_file($student->image));

        return response()->json($student);
    }

    public function showstudents($id, $slug)
    {
        $students = $this->studentRepo->query()
            ->where('id', $id)
            ->orWhere('slug', $slug)
            ->get();
        return view('students.show', compact('students'));
    }


}
