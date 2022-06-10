<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Method;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        $methods   = @getMethodsByRole();
        $nameMonth = config('constants.month_names');
        $programs  = config('constants.programs');

        return view('admin.pages.methods.index', [
            'methods'   => $methods,
            'nameMonth' => $nameMonth,
            'programs'  => $programs
        ]);
    }

    public function create()
    {
        $groups  = @getGroupsByRole();
        $lessons = Lesson::get();
        $months  = config('constants.months');

        return view('admin.pages.methods.form', [
            'groups'  => $groups,
            'lessons' => $lessons,
            'months'  => $months
        ]);
    }

    public function store(Request $request)
    {
        Method::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.methods.index');
    }

    public function show(Method $method)
    {
        //
    }

    public function edit(Method $method)
    {
        $groups  = @getGroupsByRole();
        $lessons = Lesson::get();
        $months  = config('constants.months');

        return view('admin.pages.methods.form', [
            'method'  => $method,
            'groups'  => $groups,
            'lessons' => $lessons,
            'months'  => $months
        ]);
    }

    public function update(Request $request, Method $method)
    {
        $method->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.methods.index');
    }

    public function destroy(Request $request, Method $method)
    {
        $method->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.methods.index');
    }
}
