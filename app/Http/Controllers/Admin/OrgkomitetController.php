<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orgkomitet;
use Illuminate\Http\Request;

class OrgkomitetController extends Controller
{
    public function index()
    {
        $orgkomitets = Orgkomitet::get();

        return view('admin.pages.orgkomitets.index', compact('orgkomitets'));
    }

    public function create()
    {
        return view('admin.pages.orgkomitets.form');
    }

    public function store(Request $request)
    {
        Orgkomitet::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.orgkomitets.index');
    }

    public function show(Orgkomitet $orgkomitet)
    {
        //
    }

    public function edit(Orgkomitet $orgkomitet)
    {
        return view('admin.pages.orgkomitets.form', compact('orgkomitet'));
    }

    public function update(Request $request, Orgkomitet $orgkomitet)
    {
        $orgkomitet->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.orgkomitets.index');
    }

    public function destroy(Request $request, Orgkomitet $orgkomitet)
    {
        $orgkomitet->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.orgkomitets.index');
    }
}
