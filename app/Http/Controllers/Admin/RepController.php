<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Rep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $doc_file_name = $rep->doc_note;
        $doc_file_path = $rep->doc_file;

        if ($request->has('doc_file')) {
            Storage::delete($rep->doc_file);
            $doc_file      = $request->file('doc_file');
            $doc_file_name = $doc_file->getClientOriginalName();
            $doc_file_path = $doc_file->store('documents');
        }

        $rep->update([
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_id'        => $request['doc_id'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'doc_file'      => $doc_file_path,
            'doc_note'      => $doc_file_name,
            'note'          => $request['note'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.reps.index');
    }
}
