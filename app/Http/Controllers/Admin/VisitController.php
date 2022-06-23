<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Timetable;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class VisitController extends Controller
{
    private function getExpelledMember($member, $month, $year)
    {
        return DB::table('members')
            ->join('groups', 'members.group_id', 'groups.id')
            ->join('timetables', 'groups.id', 'timetables.group_id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->join('categories', 'groups.category_id', 'categories.id')
            ->select([
                'members.id as member_id',
                'members.birthday',
                'members.form_study',
                'titles.name as group',
                'categories.name as category',
                DB::raw('MIN(timetables.from) as start'),
                DB::raw('MAX(timetables.from) as end'),
            ])
            ->where('members.id', $member)
            ->where(DB::raw('MONTH(timetables.from)'), $month)
            ->where(DB::raw('YEAR(timetables.from)'), $year)
            ->groupBy('member_id')
            ->first();
    }

    private function lessons($group, $month, $year)
    {
        return DB::table('timetables')
            ->select([
                'timetables.id',
                'timetables.from',
                'timetables.till',
                'timetables.worker_id',
                'timetables.method_id',
                'timetables.note',
                DB::raw('DATE(timetables.from) as date_lesson'),
                DB::raw('DATE_FORMAT(timetables.from, \'%d\') as day_lesson')
            ])
            ->where([
                ['group_id', $group->id],
                [DB::raw('MONTH(timetables.from)'), $month],
                [DB::raw('YEAR(timetables.from)'), $year],
            ])
            ->get();
    }

    private function lesson_days($group, $month, $year)
    {
        return DB::table('timetables')
            ->select([
                DB::raw('DATE(timetables.from) as date_lesson'),
                DB::raw('DATE_FORMAT(timetables.from, \'%d\') as day_lesson'),
                DB::raw('COUNT(timetables.from) as count_lesson'),
            ])
            ->where([
                ['group_id', $group->id],
                [DB::raw('MONTH(timetables.from)'), $month],
                [DB::raw('YEAR(timetables.from)'), $year],
            ])
            ->groupBy('date_lesson', 'day_lesson')
            ->get();
    }

    public function index(Request $request, Group $group)
    {
        // session rewrites
        if ($request->has('period'))
        {
            $request->session()->put('period.year', $request['year']);
            $request->session()->put('period.month', $request['month_id']);
        }

        // session exists
        if ($request->session()->has('period.year') && $request->session()->has('period.month'))
        {
            $isYear  = $request->session()->get('period.year');
            $isMonth = $request->session()->get('period.month');
        }

        // session doesn't exist
        else
        {
            $request->session()->put('period.year', $request['year']);
            $request->session()->put('period.month', $request['month_id']);

            $isYear  = $request->session()->get('period.year');
            $isMonth = $request->session()->get('period.month');
        }

        // dates
        $defaultYear  = 2022;  // default year  = 2022
        $defaultMonth = 6;     // default month = June
        $year         = $isYear ? $isYear : $defaultYear;
        $month        = $isMonth ? $isMonth : $defaultMonth;
        $months       = config('constants.months');
        $nameMonth    = config('constants.month_names')[$month - 1];

        // data
        $lessons      = $this->lessons($group, $month, $year);
        $lessonDays   = $this->lesson_days($group, $month, $year);

        if (count($lessons) == 0) {
            $request->session()->forget(['period.year', 'period.month']);
            $request->session()->put('period.year', $defaultYear);
            $request->session()->put('period.month', $defaultMonth);
            $request->session()->flash('warning', __('_dialog.period'));
            return redirect()->back();
        }

        return view('admin.pages.visits.index', [
            'group'       => $group,
            'months'      => $months,
            'nameMonth'   => $nameMonth,
            'numMonth'    => $month,
            'year'        => $year,
            'lessons'     => $lessons,
            'lessonDays'  => $lessonDays,
            'lessonCount' => $lessonDays->count(),
        ]);
    }

    public function topic_update(Request $request)
    {
        $timetable = Timetable::where('id', $request['timetable_id'])->first();

        $timetable->update([
            'method_id' => $request['method_id'],
            'note'      => $request['note']
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->back();
    }

    public function visit_control(Request $request)
    {
        // create record
        if ($request['action'] == 'create')
        {
            Visit::create([
                'member_id'    => $request['member_id'],
                'timetable_id' => $request['timetable_id'],
                'status'       => $request['status'],
                'reason'       => $request['reason'],
            ]);
        }

        // update record
        if ($request['action'] == 'update')
        {
            $visit = Visit::where([
                ['member_id', $request['member_id']],
                ['timetable_id', $request['timetable_id']]
            ])->first();

            $visit->update([
                'status'       => $request['status'],
                'reason'       => $request['reason'],
            ]);
        }

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->back();
    }

    public function expulsion(Request $request)
    {
        $query    = $this->getExpelledMember($request['member'], $request['month'], $request['year']);
        $paid     = 'reports/expulsion_paid.docx';
        $free     = 'reports/expulsion_free.docx';
        $today    = @getDMY(Carbon::now()) . ' г.';
        $filename = __('_field.command') . ' №' . $query->member_id . ' от ' . $today . '.docx';
        $word     = new TemplateProcessor($query->form_study == 1 ? $paid : $free);

        $word->setValues([
            'num'         => $query->member_id,
            'date_create' => $today,
            'miss_date'   => @getDMY($query->start) . ' г.',
            'drop_date'   => @getDMY($query->end) . ' г.',
        ]);

        $table     = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontStyle = ['bold' => true];

        $table->addRow();
        $table->addCell(1000)->addText('№ <w:br/>п/п', $fontStyle);
        $table->addCell(3000)->addText('Ф.И.О. <w:br/>участника', $fontStyle);
        $table->addCell(3000)->addText('Дата рождения', $fontStyle);
        $table->addCell(3000)->addText('Категория <w:br/>группы', $fontStyle);
        $table->addCell(3000)->addText('Название <w:br/>группы', $fontStyle);
        $table->addCell(3000)->addText('Форма <w:br/>обучения', $fontStyle);

        $table->addRow();
        $table->addCell(1000)->addText(1);
        $table->addCell(3000)->addText(@getFIO('member', $query->member_id));
        $table->addCell(3000)->addText(@getDMY($query->birthday));
        $table->addCell(3000)->addText($query->category);
        $table->addCell(3000)->addText($query->group);
        $table->addCell(3000)->addText($query->form_study == 1 ? __('_field.paid') : __('_field.free'));

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
