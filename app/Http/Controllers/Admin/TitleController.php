<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::get();

        return view('admin.pages.titles.index', compact('titles'));
    }

    public function create()
    {
        $specialties    = Specialty::get();
        $studies        = config('constants.form_education');

        return view(
            'admin.pages.titles.form',
            compact('specialties', 'studies')
        );
    }

    public function store(Request $request)
    {
        Title::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.titles.index');
    }

    public function show(Title $title)
    {
        //
    }

    public function edit(Title $title)
    {
        $specialties    = Specialty::get();
        $studies        = config('constants.form_education');

        return view(
            'admin.pages.titles.form',
            compact('title', 'specialties', 'studies')
        );
    }

    public function update(Request $request, Title $title)
    {
        $title->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.titles.index');
    }

    public function destroy(Request $request, Title $title)
    {
        $title->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.titles.index');
    }
}
