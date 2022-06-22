<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Cell;

class PassController extends Controller
{
    private function  getTimetableForMonth($group, $month, $year)
    {
        return DB::table('timetables')
            ->select([
                DB::raw('MONTH(timetables.from) as month'),
                DB::raw('YEAR(timetables.from) as year'),
                DB::raw('COUNT(timetables.id) as lessons'),
                DB::raw('MIN(timetables.from) as start'),
                DB::raw('MAX(timetables.from) as end'),
            ])
            ->where('group_id', $group)
            ->where(DB::raw('MONTH(timetables.from)'), $month)
            ->where(DB::raw('YEAR(timetables.from)'), $year)
            ->groupBy('month', 'year')
            ->first();
    }

    public function index()
    {
        if (Auth::user()->role_id == 5)
        {
            return view('admin.pages.passes.client', [
                'member' => Auth::user()->member,
                'passes' => @getPassesByRole(),
                'blanks' => config('constants.blanks'),
            ]);
        }

        return view('admin.pages.passes.index', [
            'passes' => @getPassesByRole(),
            'blanks' => config('constants.blanks'),
        ]);
    }

    public function create(Request $request)
    {
        if (Auth::user()->role_id != 3) {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->back();
        }

        return view('admin.pages.passes.create', [
            'members' => @getPaidMembersByGroup()
        ]);
    }

    public function store(Request $request)
    {
        $member  = Member::where('id', $request['member_id'])->first();
        $year    = explode('-', $request['month'])[0];
        $month   = explode('-', $request['month'])[1];
        $code    = $member->id . '-' . $year . '-' . $month;
        $is_pass = Pass::where('code', $code)->first();

        if ($is_pass)
        {
            $request->session()->flash('warning', 'Абонемент за выбранный месяц уже существует');
            return redirect()->back();
        }

        $group  = $member->group->id;
        $query  = $this->getTimetableForMonth($group, $month, $year);

        if (is_null($query))
        {
            $request->session()->flash('warning', __('_dialog.timetable_no'));
            return redirect()->back();
        }

        $price    = 250;
        $discount = $member->discount;
        $lessons  = $query->lessons;
        $cost     = $price * $lessons;
        $total    = $discount ? $cost - $cost * $discount->size / 100 : $cost;

        $pass = Pass::create([
            'code'      => $code,
            'year'      => $year,
            'month'     => $month,
            'member_id' => $request['member_id'],
            'group_id'  => $group,
            'worker_id' => Auth::user()->worker->id,
            'from'      => $query->start,
            'till'      => $query->end,
            'cost'      => $total,
            'lessons'   => $lessons,
            'is_active' => 0,
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.passes.edit', $pass);
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

        return view('admin.pages.passes.edit', [
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
            'status'    => $pass->status ? $pass->status : $request['status'],
            'pay_date'  => $pass->pay_date ? $pass->pay_date : $request['pay_date'],
            'pay_file'  => $pay_file_path,
            'pay_note'  => $pay_file_name,
            'is_active' => $request['status'] == 1 ? 1 : 0
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

    public function archive(Request $request, Pass $pass)
    {
        $pass->update([
            'is_active' => 2
        ]);

        $request->session()->flash('success', 'Абонемент перенесен в архив');
        return redirect()->route('admin.passes.index');
    }
}
