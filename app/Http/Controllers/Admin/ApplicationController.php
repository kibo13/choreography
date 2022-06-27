<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

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
        if ($request['status'] == 1 && $application->topic == 0)
        {
            $cost         = $application->pass->cost;
            $pricePass    = 30;
            $lessonsLimit = $application->pass->lessons;
            $lessonsExist = @getVisitsByType($application->member, $application->pass->month, $application->pass->year, [0, 1]);
            $lessonsOver  = $lessonsLimit - $lessonsExist;
            $priceLesson  = $cost / $lessonsLimit;
            $cashback     = $lessonsOver * $priceLesson - $pricePass * $lessonsOver;

            $filename = 'cash-voucher-' . $application->num . '.docx';
            $word     = new TemplateProcessor('reports/order.docx');

            $word->setValues([
                'group'      => $application->group->title->name . ' ' . $application->group->category->name,
                'id'         => $application->num,
                'created_at' => getDMY($application->updated_at),
                'member'     => getFIO('member', $application->member->id),
                'money'      => $cashback . ' ₽',
            ]);

            $word->saveAs('orders/' . $filename);

            $application->update([
                'worker_id' => Auth::user()->worker->id,
                'status'    => $request['status'],
                'note'      => $request['note'],
                'voucher'   => $filename
            ]);
        }

        else
        {
            $application->update([
                'worker_id' => Auth::user()->worker->id,
                'status'    => $request['status'],
                'note'      => $request['note']
            ]);
        }

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.applications.index');
    }
}
