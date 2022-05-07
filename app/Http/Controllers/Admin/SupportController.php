<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role_id)
        {
            case 1:
            case 2:
                $applications = Application::get();
                break;

            case 5:
                $applications = Application::where('member_id', Auth::user()->member->id)->get();
                break;

            default:
                $applications = [];
                break;
        }

        return view('admin.pages.support.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.pages.support.form');
    }

    public function store(SupportRequest $request)
    {
        unset($request['file']);

        if ($request->has('file')) {
            $file       = $request->file('file');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('applications');
        }

        Application::create([
            'num'       => @bk_rand('number', null, 10),
            'member_id' => Auth::user()->member->id,
            'group_id'  => Auth::user()->member->group_id,
            'topic'     => $request['topic'],
            'desc'      => $request['desc'],
            'file'      => $file_path ?? null ? $file_path : null,
            'note'      => $file_name ?? null ? $file_name : null
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.support.index');
    }

    public function show(Application $application)
    {
        return view('admin.pages.support.show', compact('application'));
    }

    public function edit(Application $application)
    {
        return view('admin.pages.support.form', compact('application'));
    }

    public function update(SupportRequest $request, Application $application)
    {
        unset($request['file']);

        if ($request->has('file')) {
            Storage::delete($application->file);
            $file       = $request->file('file');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('applications');
        }

        $application->update([
            'group_id'  => Auth::user()->member->group_id,
            'topic'     => $request['topic'],
            'desc'      => $request['desc'],
            'file'      => $file_path ?? null ? $file_path : null,
            'note'      => $file_name ?? null ? $file_name : null
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.support.index');
    }

    public function destroy(Request $request, Application $application)
    {
        $application->delete();
        Storage::delete($application->file);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.support.index');
    }
}
