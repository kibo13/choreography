<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pass;
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
        $lessons = DB::table('visits')
            ->join('timetables', 'visits.timetable_id', 'timetables.id')
            ->select([
                DB::raw('DATE(timetables.from) as date_lesson'),
                'visits.status'
            ])
            ->where('visits.member_id', $pass->member_id)
            ->where(DB::raw('MONTH(timetables.from)'), $pass->month)
            ->where(DB::raw('YEAR(timetables.from)'), $pass->year)
            ->get();

        $days = DB::table('visits')
            ->join('timetables', 'visits.timetable_id', 'timetables.id')
            ->selectRaw('DATE(timetables.from) as date_lesson')
            ->where('visits.member_id', $pass->member_id)
            ->where(DB::raw('MONTH(timetables.from)'), $pass->month)
            ->where(DB::raw('YEAR(timetables.from)'), $pass->year)
            ->groupBy('date_lesson')
            ->get();

        $months   = config('constants.month_names');
        $filename = __('_field.pass') . ' №' . $pass->id . '.docx';
        $word     = new TemplateProcessor('reports/pass.docx');

        $word->setValues([
            'id'         => $pass->id,
            'date_issue' => $pass->pay_date ? getDMY($pass->pay_date) . 'г.' : '-',
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
            'month'      => $months[$pass->month - 1]
        ]);

        $table     = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $bgCell    = ['bgColor' => 'e0e0e0'];
        $fontText  = ['bold' => true];
        $alignText = ['alignment' => Jc::CENTER, 'align' => Cell::VALIGN_CENTER];
        $fields    = [__('_field.date'), __('_field.attendance')];


        foreach ($fields as $index => $field)
        {
            $table->addRow();
            $table->addCell()->addText($field, $fontText);

            if ($index == 0)
            {
                foreach ($days as $day)
                {
                    $table->addCell(null, $bgCell)->addText(@getDM($day->date_lesson), [], $alignText);
                }
            }

            else
            {
                foreach ($days as $day)
                {
                    $visits = '';

                    foreach ($lessons as $lesson)
                    {
                        if ($day->date_lesson == $lesson->date_lesson)
                        {
                            if ($lesson->status == 0) {
                                $visits .= '✖ <w:br/>';
                            }
                            elseif ($lesson->status == 1) {
                                $visits .= '✔ <w:br/>';
                            } else {
                                $visits .= 'O <w:br/>';
                            }
                        }
                    }

                    $table->addCell()->addText($visits, [], $alignText);
                }
            }
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
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
