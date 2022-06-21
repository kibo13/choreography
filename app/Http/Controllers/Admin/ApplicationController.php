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
        $apps   = @getAppsByRole();
        $tops   = config('constants.topics');
        $states = config('constants.states');

        return view('admin.pages.applications.index', [
            'applications' => $apps,
            'total'        => $apps->count(),
            'pending'      => $apps->where('status', 0)->count(),
            'complete'     => $apps->where('status', 1)->count(),
            'decline'      => $apps->where('status', 2)->count(),
            'tops'         => $tops,
            'states'       => $states
        ]);
    }

    public function edit(Application $application)
    {
        $tops   = config('constants.topics');
        $states = config('constants.states');

        return view('admin.pages.applications.form', [
            'application' => $application,
            'tops'        => $tops,
            'states'      => $states
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $application->update([
            'worker_id' => Auth::user()->worker->id,
            'status'    => $request['status'],
            'note'      => $request['note']
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.applications.index');
    }
}
