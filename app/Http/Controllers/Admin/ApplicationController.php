<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role_id)
        {
            case 1:
            case 2:
                $applications = Application::get();
                $total        = Application::count();
                $pending      = Application::where('status', 0)->count();
                $complete     = Application::where('status', 1)->count();
                break;

            case 3:
                $groups       = Auth::user()->worker->groups->pluck('id');
                $applications = Application::whereIn('group_id', $groups)->orderBy('status')->get();
                $total        = Application::whereIn('group_id', $groups)->count();
                $pending      = Application::whereIn('group_id', $groups)->where('status', 0)->count();
                $complete     = Application::whereIn('group_id', $groups)->where('status', 1)->count();
                break;

            default:
                $applications = [];
                $total        = 0;
                $pending      = 0;
                $complete     = 0;
                break;
        }

        return view(
            'admin.pages.applications.index',
            compact('applications', 'total', 'pending', 'complete')
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Application $application)
    {
        return view('admin.pages.applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        //
    }

    public function update(Request $request, Application $application)
    {
        $application->update([
            'worker_id' => Auth::user()->worker->id,
            'status'    => 1
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.applications.index');
    }

    public function destroy(Application $application)
    {
        //
    }
}
