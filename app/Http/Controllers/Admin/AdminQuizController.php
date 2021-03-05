<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Subjectmatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AssignmentRequest;

class AdminQuizController extends Controller
{
    //

    public function create()
    {
        //
        if (Gate::denies('manage-users')) {
            abort(403);
        }

        $subjects = Subjectmatter::get();
        return view('admin.tasks.quiz.create', compact('subjects'));
    }

    public function store(AssignmentRequest $request)
    {
        //
        if (Gate::denies('manage-users')) {
            abort(403);
        }
        $quiz = Quiz::create([
            'schoolclass_id' => $request->classId,
            'subjectmatter_id' => $request->subject,
            'admin_id' => Auth::user()->admins[0]->id,
            'title' => $request->title,
            'instructions' => $request->instructions,
            'point' => $request->point,
            'due' => $request->due,
        ]);
        return redirect()->back()->with('success', 'lol');
    }

    public function show($idKelas, $id)
    {
        //
        if (Gate::denies('manage-users')) {
            abort(403);
        }

        $quiz = Quiz::findOrFail($id);

        return view('admin.tasks.quiz.show', compact('quiz', 'idKelas'));
    }

    public function edit($classId, $id)
    {
        if (Gate::denies('manage-users')) {
            abort(403);
        }

        $point = [null => 'Ungraded', '100' => '100', '10' => '10'];

        $quiz = Quiz::findOrFail($id);
        return view('admin.tasks.quiz.edit', compact('quiz', 'classId', 'point'));
    }

    public function update(AssignmentRequest $request, $id)
    {
        //
        if (Gate::denies('manage-users')) {
            abort(403);
        }

        $quiz = Quiz::findOrFail($id);

        $quiz->update([
            'schoolclass_id' => $request->classId,
            'subjectmatter_id' => $request->subject,
            'admin_id' => Auth::user()->admins[0]->id,
            'title' => $request->title,
            'instructions' => $request->instructions,
            'point' => $request->point,
            'due' => $request->due,
        ]);

        return redirect()->back()->with('success', 'lol');
    }

    public function destroy($id)
    {
        //
        if (Gate::denies('manage-users')) {
            abort(403);
        }
        
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        Storage::disk('local')->delete($quiz->attachment);
        return redirect()->back()->with('success', 'lol');
    }
}
