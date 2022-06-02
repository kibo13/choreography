<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diplom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiplomController extends Controller
{
    public function store(Request $request)
    {
        $file      = $request->file('file');
        $file_name = is_null($file) ? null : $file->getClientOriginalName();
        $file_path = is_null($file) ? null : $file->store('achievements');

        Diplom::create([
            'achievement_id' => $request['achievement_id'],
            'member_id'      => $request['member_id'],
            'file'           => $file_path,
            'note'           => $file_name
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->back();
    }

    public function destroy(Request $request, Diplom $diplom)
    {
        $diplom->delete();
        Storage::delete($diplom->file);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->back();
    }
}
