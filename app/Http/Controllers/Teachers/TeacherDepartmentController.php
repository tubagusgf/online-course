<?php

namespace App\Http\Controllers\Teachers;

use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class TeacherDepartmentController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Gate::denies('manage-courses')) {
            abort(403);
        }
        
        $datas = Department::orderBy('name')->paginate(10);
        return view('teacher.dashboard.departments.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('manage-courses')) {
            abort(403);
        }

        $teachers = Teacher::get();
        return view('teacher.dashboard.departments.create', compact('teachers'));
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
        if (Gate::denies('manage-courses')) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'information' => 'required'
        ]);

        Department::create([
            'teacher_id' => $request->chief,
            'name' => $request->name,
            'information' => $request->information
        ]);

        return redirect()->back()->with('success', 'lol');
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
        if (Gate::denies('manage-courses')) {
            abort(403);
        }

        $department = Department::findOrFail($id);
        $teachers = Teacher::get();
        return view('teacher.dashboard.departments.edit', compact('teachers', 'department'));
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
        //
        if (Gate::denies('manage-courses')) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required',
            'information' => 'required'
        ]);
        $department = Department::findOrFail($id);

        $department->update([
            'teacher_id' => $request->chief,
            'name' => $request->name,
            'information' => $request->information
        ]);

        return redirect()->back()->with('success', 'lol');
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
        if (Gate::denies('manage-courses')) {
            abort(403);
        }
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->back()->with('success', 'lol');
    }
}