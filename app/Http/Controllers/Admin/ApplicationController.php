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
        $applications = Application::orderBy('status', 'asc')->get();
        $total        = Application::count();
        $pending      = Application::where('status', 0)->count();
        $complete     = Application::where('status', 1)->count();

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
        $application->update(['status' => 1]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.applications.index');
    }

    public function destroy(Application $application)
    {
        //
    }
}
