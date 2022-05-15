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
        if ($request->has('file'))
        {
            $file      = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->store('achievements');
        }

        Diplom::create([
            'achievement_id' => $request['achievement_id'],
            'member_id'      => $request['member_id'],
            'file'           => $file_path ?? null ? $file_path : null,
            'note'           => $file_name ?? null ? $file_name : null
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
