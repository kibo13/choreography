<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Rep;
use Illuminate\Http\Request;

class RepController extends Controller
{
    public function index()
    {
        $reps = Rep::get();

        return view('admin.pages.reps.index', compact('reps'));
    }

    public function edit(Rep $rep)
    {
        $types = config('constants.type_rep');
        $docs  = Doc::where('id', '!=', 3)->get();

        return view('admin.pages.reps.form', [
            'rep'   => $rep,
            'types' => $types,
            'docs'  => $docs,
        ]);
    }

    public function update(Request $request, Rep $rep)
    {
        $rep->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.reps.index');
    }
}
