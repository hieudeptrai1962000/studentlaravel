<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty\Faculty;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected $facultyRepo;

    public function __construct(FacultyRepositoryInterface $facultyRepository)
    {
        $this->facultyRepo = $facultyRepository;
    }

    public function index()
    {
        $faculties = $this->facultyRepo->paginate();
        return view('faculty.index', compact('faculties'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $newFaculty = new Faculty();
        return view('faculty.edit', compact('newFaculty'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(FacultyRequest $request)
    {
        $this->facultyRepo->store($request->all());
        return redirect()->route('faculties.index')->with('success', 'Successfully !');

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
        $faculty = $this->facultyRepo->find($id);
        return view('faculty.edit', compact('faculty'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(FacultyRequest $request, $id)
    {
        if ($request->name == $this->facultyRepo->find($id)->name) {
            return redirect()->route('faculties.index')->with('warning', 'Kh??ng c?? g?? thay ?????i c??? !!!');
        } else {
            $this->facultyRepo->find($id)->update($request->all());
            return redirect()->route('faculties.index')->with('success', 'Update faculty successfully !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->facultyRepo->destroy($id);
        return redirect()->route('faculties.index')->with('success', 'Successfully!');
    }
}
