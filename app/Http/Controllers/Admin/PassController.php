<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $today   = Carbon::now();
        $members = @getPaidMembersByGroup();
        $passes  = @getDeactivePassesByGroup();
        $blanks  = config('constants.blanks');

        if (Auth::user()->role_id == 5)
        {
            $member         = Auth::user()->member;
            $activePass     = Pass::where('member_id', $member->id)->where('is_active', 1)->first();
            $deactivePasses = Pass::where('member_id', $member->id)->where('is_active', 0)->get();

            return view('admin.pages.passes.client', [
                'member'         => $member,
                'activePass'     => $activePass,
                'deactivePasses' => $deactivePasses,
                'blanks'         => $blanks,
            ]);
        }

        return view('admin.pages.passes.index', [
            'today'   => $today,
            'members' => $members,
            'passes'  => $passes,
            'blanks'  => $blanks,
        ]);
    }

    public function create(Request $request)
    {
        if (Auth::user()->role_id != 3) {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->back();
        }

        $member   = $request['member_id'];
        $payments = config('constants.payments');

        return view('admin.pages.passes.form', [
            'member'   => $member,
            'payments' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $member        = Member::where('id', $request['member_id'])->first();
        $discount      = $member->discount;
        $group         = $member->group->id;
        $price         = $member->group->price;
        $cost          = $discount ? $price - $price * $discount->size / 100 : $price;
        $lessons       = $member->group->lessons;
        $pay_file      = $request->file('pay_file');
        $pay_file_name = is_null($pay_file) ? null : $pay_file->getClientOriginalName();
        $pay_file_path = is_null($pay_file) ? null : $pay_file->store('payments');

        Pass::create([
            'member_id' => $request['member_id'],
            'group_id'  => $group,
            'worker_id' => $this->worker()->id,
            'from'      => $request['from'],
            'till'      => $request['till'],
            'cost'      => $cost,
            'lessons'   => $lessons,
            'status'    => $request['status'],
            'pay_date'  => $request['pay_date'],
            'pay_file'  => $pay_file_path,
            'pay_note'  => $pay_file_name
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

        return view('admin.pages.passes.form', [
            'pass'     => $pass,
            'payments' => $payments,
        ]);
    }

    public function update(Request $request, Pass $pass)
    {
        $pay_file_name = $pass->pay_note;
        $pay_file_path = $pass->pay_file;

        if ($request->has('pay_file')) {
            Storage::delete($pass->pay_file);
            $pay_file      = $request->file('pay_file');
            $pay_file_name = $pay_file->getClientOriginalName();
            $pay_file_path = $pay_file->store('payments');
        }

        $pass->update([
            'from'      => $request['from'],
            'till'      => $request['till'],
            'status'    => $request['status'],
            'pay_date'  => $request['pay_date'],
            'pay_file'  => $pay_file_path,
            'pay_note'  => $pay_file_name
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.passes.index');
    }

    public function destroy(Request $request, Pass $pass)
    {
        $pass->delete();
        Storage::delete($pass->pay_file);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.passes.index');
    }

    public function bill(Pass $pass)
    {
        // set filename
        $filename = 'Квитацния об оплате абонемента №' . $pass->id;

        // create empty template
        $word = new TemplateProcessor('reports/bill.docx');

        $word->setValues([
            'id'         => $pass->id,
            'pay_date'   => $pass->pay_date ? @getDMY($pass->pay_date) . 'г.' : '-',
            'member'     => @getFIO('member', $pass->member->id),
            'group'      => $pass->member->group->title->name . ' ' . $pass->member->group->category->name,
            'phone'      => $pass->member->phone,
            'from'       => @getDMY($pass->from) . 'г.',
            'till'       => @getDMY($pass->till) . 'г.',
            'total'      => $pass->cost . ' ₽',
            'lessons'    => $pass->lessons,
        ]);

        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function prolong(Request $request, Pass $pass)
    {
        $pass->update(['is_active' => 0]);

        Pass::create([
            'member_id' => $pass->member_id,
            'group_id'  => $pass->group_id,
            'worker_id' => $this->worker()->id,
            'from'      => date('Y-m-d', strtotime($pass->till . ' +1 days')),
            'till'      => date('Y-m-d', strtotime($pass->till . ' +14 days')),
            'cost'      => $pass->cost,
            'lessons'   => $pass->lessons,
            'is_active' => 1
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.passes.index');
    }
}
