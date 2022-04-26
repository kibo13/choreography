<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::get();

        return view('admin.pages.lessons.index', compact('lessons'));
    }

    public function create()
    {
        return view('admin.pages.lessons.form');
    }

    public function store(Request $request)
    {
        Lesson::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.lessons.index');
    }

    public function show(Lesson $lesson)
    {
        //
    }

    public function edit(Lesson $lesson)
    {
        return view('admin.pages.lessons.form', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.lessons.index');
    }

    public function destroy(Request $request, Lesson $lesson)
    {
        $lesson->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.lessons.index');
    }
}
