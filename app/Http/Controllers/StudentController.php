<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{


    protected $studentRepo;
    protected $facultyRepo;

    public function __construct(
        StudentRepositoryInterface $studentRepo,
        FacultyRepositoryInterface $facultyRepository
    )
    {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $student = $this->studentRepo->paginate();
        return view('student.main', compact('student'));
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
            $destinationPath = 'uploads';
            $file_name = $file->move($destinationPath, $file->getClientOriginalName());

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
        return view('student.create', compact('faculty'));
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
}
