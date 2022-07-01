<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject\Subject;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubjectController extends Controller
{

    protected $subjectRepo;

    public function __construct(SubjectRepositoryInterface $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subjects = $this->subjectRepo->paginate();
        return view('subject.index', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(SubjectRequest $request)
    {
        $this->subjectRepo->store($request->all());
        return redirect()->route('subjects.index')->with('success', 'Successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $newSubject = new Subject();
        return view('subject.edit', compact('newSubject'));
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
        $subject = $this->subjectRepo->find($id);
        return view('subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(SubjectRequest $request, $id)
    {
        if ($request->name == $this->subjectRepo->find($id)->name) {
            return redirect()->route('subjects.index')->with('warning', 'Không có gì thay đổi cả !!!');
        } else {
            $this->subjectRepo->find($id)->update($request->all());
            return redirect()->route('subjects.index')->with('success', 'Update faculty successfully !');
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
        $this->subjectRepo->destroy($id);
        return redirect()->route('subjects.index')->with('success', 'Successfully!');
    }
}
