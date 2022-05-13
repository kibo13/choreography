<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Cell;

class PassController extends Controller
{
    private function worker()
    {
        return Auth::user()->worker;
    }

    public function index()
    {
        switch (Auth::user()->role_id) {
            case 1:
            case 2:
                $passes = Pass::get();
                break;

            case 3:
                $groups = $this->worker()->groups->pluck('id');
                $passes = Pass::whereIn('group_id', $groups)->get();
                break;

            case 4:
            case 5:
                $passes = [];
                break;
        }

        return view('admin.pages.passes.index', compact('passes'));
    }

    public function create(Request $request)
    {
        if (is_null($this->worker())) {
            $request->session()->flash('warning', __('_dialog.group_null'));
            $groups = [];
        } else {
            $groups = $this->worker()->groups->pluck('id');
        }

        $members  = Member::whereIn('group_id', $groups)->where('form_study', 1)->get();
        $payments = config('constants.payments');

        return view(
            'admin.pages.passes.form',
            compact('members', 'payments')
        );
    }

    public function store(Request $request)
    {
        $is_pass  = Pass::where('member_id', $request['member_id'])->first();
        $today    = Carbon::now()->addHour(5);

        if ($is_pass && $today <= $is_pass->till)
        {
            $request->session()->flash('warning', __('_dialog.pass_active'));
            return redirect()->back();
        }

        if (Auth::user()->role_id != 3)
        {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->back();
        }

        $member   = Member::where('id', $request['member_id'])->first();
        $discount = $member->discount;
        $group    = $member->group->id;
//        $from     = Carbon::now()->addHour(5);
//        $till     = Carbon::now()->addHour(5)->addMonth();
        $price    = $member->group->price;
        $cost     = $discount ? $price - $price * $discount->size / 100 : $price;
        $lessons  = $member->group->lessons;

        Pass::create([
            'member_id' => $request['member_id'],
            'group_id'  => $group,
            'worker_id' => $this->worker()->id,
            'from'      => $request['from'],
            'till'      => $request['till'],
            'cost'      => $cost,
            'lessons'   => $lessons,
            'status'    => $request['status'],
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.passes.index');
    }

    public function show(Pass $pass)
    {
        $word = new TemplateProcessor('reports/pass.docx');

        $word->setValues([
            'id'         => $pass->id,
            'date_issue' => getDMY(Carbon::now()) . 'г.',
            'member'     => @getFIO('member', $pass->member->id),
            'birthday'   => @getDMY($pass->member->birthday) . 'г.',
            'address'    => $pass->member->address_fact,
            'group'      => $pass->member->group->title->name,
            'category'   => $pass->member->group->category->name,
            'from'       => @getDMY($pass->from) . 'г.',
            'till'       => @getDMY($pass->till) . 'г.',
            'worker'     => @getFIO('worker', $pass->worker->id),
            'cost'       => $pass->cost,
            'lessons'    => $pass->lessons,
        ]);

        $table     = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $bgCell    = ['bgColor' => 'e0e0e0'];
        $fontText  = ['bold' => true];
        $alignText = ['alignment' => Jc::CENTER, 'align' => Cell::VALIGN_CENTER];

        for ($i = 1; $i <= floor($pass->lessons / 4); $i++)
        {
            $table->addRow();
            $table->addCell(2000);

            switch ($i) {
                case 1:
                    $start = 1;
                    $end   = 4;
                    break;

                case 2:
                    $start = 5;
                    $end   = 8;
                    break;

                case 3:
                    $start = 9;
                    $end   = 12;
                    break;
            }

            for ($j = $start; $j <= $end; $j++)
            {
                $table->addCell(1000, $bgCell)->addText($j, [], $alignText);
            }

            $table->addRow();
            $table->addCell(2000)->addText(__('_field.date'), $fontText);

            for ($j = $start; $j <= $end; $j++)
            {
                $table->addCell(1000);
            }

            $table->addRow();
            $table->addCell(2000)->addText(__('_field.sign_head'), $fontText);

            for ($j = $start; $j <= $end; $j++)
            {
                $table->addCell(1000);
            }
        }

        $word->setComplexBlock('table', $table);

        $filename = __('_field.pass') . ' №' . $pass->id;
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function edit(Pass $pass)
    {
        $payments = config('constants.payments');

        return view(
            'admin.pages.passes.form',
            compact('pass', 'payments')
        );
    }

    public function update(Request $request, Pass $pass)
    {
        $pass->update([
            'from'      => $request['from'],
            'till'      => $request['till'],
            'status'    => $request['status'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.members.index');
    }

    public function destroy(Request $request, Pass $pass)
    {
        $pass->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.passes.index');
    }
}
