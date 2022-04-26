<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::get();

        return view('admin.pages.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.pages.specialties.form');
    }

    public function store(Request $request)
    {
        Specialty::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.specialties.index');
    }

    public function show(Specialty $specialty)
    {
        //
    }

    public function edit(Specialty $specialty)
    {
        return view('admin.pages.specialties.form', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $specialty->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.specialties.index');
    }

    public function destroy(Request $request, Specialty $specialty)
    {
        $specialty->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.specialties.index');
    }
}
