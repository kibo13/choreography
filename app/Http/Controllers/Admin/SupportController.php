<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    public function index()
    {
        $apps   = @getAppsByRole();
        $tops   = config('constants.topics');
        $states = config('constants.states');

        return view('admin.pages.support.index', [
            'applications' => $apps,
            'tops'         => $tops,
            'states'       => $states,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->has('pass'))
        {
            $app = Application::where('pass_id', $request['pass'])->first();

            if ($app)
            {
                $request->session()->flash('warning', 'Заявка по данному абонементу уже создана');
                return redirect()->back();
            }
        }

        $tops = config('constants.topics');

        return view('admin.pages.support.form', compact('tops'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('files'))
        {
            foreach ($request->file('files') as $index => $file)
            {
                $name = $file->getClientOriginalName();
                $path = $file->store('applications');

                $insert[$index]['name'] = $name;
                $insert[$index]['path'] = $path;
            }
        }

        if (is_null($request['pass_id']) && $request['topic'] == 0)
        {
            $request->session()->flash('warning', __('_dialog.pass_need'));
            return redirect()->back();
        }

        Application::create([
            'pass_id'   => $request->has('pass_id') ? $request['pass_id'] : null,
            'num'       => @bk_rand('number', null, 10),
            'member_id' => Auth::user()->member->id,
            'group_id'  => Auth::user()->member->group_id,
            'topic'     => $request['topic'],
            'desc'      => $request['desc'],
            'files'     => isset($insert) ? $insert : null
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.support.index');
    }

    public function edit(Application $application)
    {
        $tops = config('constants.topics');

        return view('admin.pages.support.form', [
            'application' => $application,
            'tops'        => $tops
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $insert = $application->files;

        if ($request->hasFile('files'))
        {
            if ($insert)
            {
                foreach ($application->files as $file)
                {
                    Storage::delete($file['path']);
                }
            }

            foreach ($request->file('files') as $index => $file)
            {
                $name = $file->getClientOriginalName();
                $path = $file->store('applications');

                $insert[$index]['name'] = $name;
                $insert[$index]['path'] = $path;
            }
        }

        $application->update([
            'group_id'  => Auth::user()->member->group_id,
            'desc'      => $request['desc'],
            'files'     => $insert,
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.support.index');
    }

    public function destroy(Request $request, Application $application)
    {
        $application->delete();

        if ($application->files)
        {
            foreach ($application->files as $file)
            {
                Storage::delete($file['path']);
            }
        }

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.support.index');
    }
}
