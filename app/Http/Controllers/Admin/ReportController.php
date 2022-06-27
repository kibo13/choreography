<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Award;
use App\Models\Group;
use App\Models\Member;
use App\Models\Pass;
use App\Models\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function groups()
    {
        switch (Auth::user()->role_id)
        {
            case 3:
                $groups = Auth::user()->worker->groups->pluck('id');
                break;

            default:
                $groups = Group::pluck('id');
        }

        return $groups;
    }

    public function index()
    {
        $reports = config('constants.reports');

        return view('admin.pages.reports.index', compact('reports'));
    }

    public function privileges(Request $request)
    {
        $members = DB::table('passes')
            ->join('members', 'passes.member_id', 'members.id')
            ->join('discounts', 'members.discount_id', 'discounts.id')
            ->select([
                'passes.member_id as member_id',
                'discounts.name',
                'discounts.size',
                'members.discount_note',
                'passes.id as pass_id',
                'passes.from as pass_from',
                'passes.till as pass_till',
                DB::raw('(passes.lessons * 250) as price'),
                'passes.cost as cost',
                'passes.status'
            ])
            ->whereIn('members.group_id', $this->groups())
            ->whereNotNull('members.discount_id')
            ->where('members.discount_id', '!=', 5)
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->get();

        $money = DB::table('passes')
            ->join('members', 'passes.member_id', 'members.id')
            ->join('discounts', 'members.discount_id', 'discounts.id')
            ->selectRaw('SUM(passes.cost) as money')
            ->whereIn('members.group_id', $this->groups())
            ->whereNotNull('members.discount_id')
            ->where('members.discount_id', '!=', 5)
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->first()
            ->money;

        // set filename
        $filename = config('constants.reports')[0]['name'] . '.docx';

        // create empty template
        $word = new TemplateProcessor('reports/privileges.docx');

        $word->setValues([
            'title'        => config('constants.reports')[0]['name'],
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
            'count_passes' => $members->count(),
            'count_money'  => $money . ' ₽'
        ]);

        // styles for tables
        $cellRowSpan     = ['vMerge' => 'restart'];
        $cellRowContinue = ['vMerge' => 'continue'];
        $cellHCentered   = ['align' => 'center'];

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(null, $cellRowSpan)->addText('№', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('ФИО льготника', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Категория <w:br/>льготника', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Размер скидки', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Название документа <w:br/>подтверждающего скидку', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Номер абонемента', $fontText);
        $table->addCell(null, ['gridSpan' => 2])->addText('Период действия', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Стоимость абонемента', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('Сумма оплаченная <w:br/>за абонемент со скидкой', $fontText);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(500)->addText('начало', null, $cellHCentered);
        $table->addCell(500)->addText('окончание', null, $cellHCentered);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);

        foreach ($members as $index => $member) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $member->member_id));
            $table->addCell()->addText($member->name);
            $table->addCell()->addText($member->size . '%');
            $table->addCell()->addText($member->discount_note ? $member->discount_note : '-');
            $table->addCell()->addText('№' . $member->pass_id);
            $table->addCell()->addText(@getDMY($member->pass_from));
            $table->addCell()->addText(@getDMY($member->pass_till));
            $table->addCell()->addText($member->price . ' ₽');
            $table->addCell()->addText($member->cost . ' ₽');
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function passes(Request $request, $type)
    {
        // get list of passes
        switch ($type) {
            case 1:
                $filename = config('constants.reports')[1]['name'];
                $passes   = DB::table('passes')
                    ->join('groups', 'passes.group_id', '=', 'groups.id')
                    ->join('titles', 'groups.title_id', '=', 'titles.id')
                    ->join('categories', 'groups.category_id', '=', 'categories.id')
                    ->join('members', 'passes.member_id', '=', 'members.id')
                    ->select([
                        'passes.id',
                        'passes.member_id as member',
                        'titles.name as group',
                        'categories.name as category',
                        'passes.from',
                        'passes.till',
                        'passes.cost',
                        'passes.lessons',
                        'passes.status',
                        'passes.pay_date',
                        'passes.month',
                        'passes.year'
                    ])
                    ->whereIn('passes.group_id', $this->groups())
                    ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
                    ->where(function ($query) {
                        $query
                            ->whereNull('members.discount_id')
                            ->orWhere('members.discount_id', 5);
                    })
                    ->get();
                break;

            case 2:
                $filename = config('constants.reports')[2]['name'];
                $passes   = DB::table('passes')
                    ->join('groups', 'passes.group_id', '=', 'groups.id')
                    ->join('titles', 'groups.title_id', '=', 'titles.id')
                    ->join('categories', 'groups.category_id', '=', 'categories.id')
                    ->join('members', 'passes.member_id', '=', 'members.id')
                    ->select([
                        'passes.id',
                        'passes.member_id as member',
                        'titles.name as group',
                        'categories.name as category',
                        'passes.from',
                        'passes.till',
                        'passes.cost',
                        DB::raw('(passes.lessons * 250) as price'),
                        'passes.lessons',
                        'passes.status',
                        'passes.pay_date',
                        'passes.month',
                        'passes.year'
                    ])
                    ->whereIn('passes.group_id', $this->groups())
                    ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
                    ->where('members.discount_id', '!=', 5)
                    ->get();
                break;
        }

        // create empty template
        $word = new TemplateProcessor('reports/passes.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' г.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' г.',
            'till'     => @getDMY($request['till']) . ' г.',
            'total'    => $passes->count()
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('№ <w:br/>абонемента', $fontText);
        $table->addCell()->addText('Дата начала действия', $fontText);
        $table->addCell()->addText('Дата окончания действия', $fontText);

        if ($type == 1)
        {
            $table->addCell()->addText('Стоимость абонемента', $fontText);
        }

        else
        {
            $table->addCell()->addText('Полная стоимость абонемента', $fontText);
            $table->addCell()->addText('Стоимость абонемента со скидкой', $fontText);
        }

        $table->addCell()->addText('Кол-во занятий', $fontText);
        $table->addCell()->addText('Кол-во посещений', $fontText);
        $table->addCell()->addText('Кол-во абонементов', $fontText);
        $table->addCell()->addText('Оплачено', $fontText);
        $table->addCell()->addText('Дата оплаты', $fontText);

        foreach ($passes as $index => $pass) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $pass->member));
            $table->addCell()->addText($pass->group);
            $table->addCell()->addText($pass->category);
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getDMY($pass->from));
            $table->addCell()->addText(@getDMY($pass->till));

            if ($type == 1)
            {
                $table->addCell()->addText($pass->cost . ' ₽');
            }

            else
            {
                $table->addCell()->addText($pass->price . ' ₽');
                $table->addCell()->addText($pass->cost . ' ₽');
            }

            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText(@getVisitsByType(Member::where('id', $pass->member)->first(), $pass->month, $pass->year, [1]));
            $table->addCell()->addText(1);
            $table->addCell()->addText($pass->status == 1 ? 'оплачено' : 'не оплачено');
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : __('_record.no'));
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function amounts(Request $request)
    {
        // get amounts only for paid passes
        $passes = Pass::whereIn('group_id', $this->groups())
            ->where('status', 1)
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->get();

        $money  = DB::table('passes')
            ->selectRaw('SUM(passes.cost) as amount')
            ->whereIn('group_id', $this->groups())
            ->where('status', 1)
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->first()
            ->amount;

        // set filename
        $filename = config('constants.reports')[3]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/amounts.docx');

        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
            'count_passes' => $passes->count(),
            'count_money'  => $money . ' ₽'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('Специализация', $fontText);
        $table->addCell()->addText('Дата покупки абонемента', $fontText);
        $table->addCell()->addText('Номер абонемента', $fontText);
        $table->addCell()->addText('Кол-во абонементов', $fontText);
        $table->addCell()->addText('Сумма оплаченная за абонемент', $fontText);

        foreach ($passes as $index => $pass) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $pass->member->id));
            $table->addCell()->addText($pass->group->title->name);
            $table->addCell()->addText($pass->group->category->name);
            $table->addCell()->addText($pass->group->title->specialty->name);
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : '-');
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(1);
            $table->addCell()->addText($pass->cost . ' ₽');
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function ages(Request $request)
    {
        if ($request['title_id'])
        {
            $team    = Title::where('id', $request['title_id'])->first();
            $groups  = $team->groups->pluck('id');
            $teacher = @getFIO('worker', $team->groups[0]->workers->first()->id);
            $members = Member::whereIn('group_id', $groups)->orderBy('group_id')->orderBy('age')->get();
        }

        else
        {
            $teacher = @getFIO('worker', Auth::user()->worker->id);
            $members = Member::whereIn('group_id', $this->groups())->orderBy('group_id')->orderBy('age')->get();
        }

        // set filename
        $filename = config('constants.reports')[4]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/ages.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'teacher'  => $teacher,
            'group'    => $members->first()->group->title->name,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' г.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' г.',
            'till'     => @getDMY($request['till']) . ' г.'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№', $fontText);
        $table->addCell(7000)->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('Возраст', $fontText);

        foreach ($members as $index => $member) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $member->id));
            $table->addCell()->addText($member->group->category->name);
            $table->addCell()->addText($member->age);
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function awards(Request $request)
    {
        // get awards
        $awards = Award::whereIn('group_id', $this->groups())
            ->whereBetween('date_reg', [$request['from'], $request['till']])
            ->get();

        // set filename
        $filename = config('constants.reports')[5]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/awards.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' г.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' г.',
            'till'     => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(2000)->addText('Номер регистрации', $fontText);
        $table->addCell(2000)->addText('Дата регистрации', $fontText);
        $table->addCell(2000)->addText('Дата выдачи  <w:br/>документа', $fontText);
        $table->addCell(5000)->addText('Название документа', $fontText);
        $table->addCell(3000)->addText('Краткое содержание', $fontText);
        $table->addCell(2000)->addText('Кем выдан', $fontText);
        $table->addCell(3000)->addText('Примечание', $fontText);

        foreach ($awards as $award) {
            $table->addRow();
            $table->addCell()->addText('№' . $award->num);
            $table->addCell()->addText(@getDMY($award->date_reg));
            $table->addCell()->addText(@getDMY($award->date_doc));
            $table->addCell()->addText($award->name_doc);
            $table->addCell()->addText('Выдан коллективу <w:br/>' . $award->group->title->name . ' / ' . $award->group->category->name . '<w:br/>(' . $award->totalSeats() . ' чел.)');
            $table->addCell()->addText('Организаторы конкурса: <w:br/>' . $award->orgkomitet->name);
            $table->addCell()->addText($award->note);
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function collectives(Request $request)
    {
        // get groups
        $groups = DB::table('groups')
            ->join('titles', 'groups.title_id', '=', 'titles.id')
            ->join('specialties', 'titles.specialty_id', '=', 'specialties.id')
            ->join('categories', 'groups.category_id', '=', 'categories.id')
            ->select([
                'titles.name as title',
                'specialties.name as specialty',
                DB::raw('SUM(groups.basic_seats + groups.extra_seats) as seats'),
                DB::raw('SUM(groups.workload) as workload'),
                DB::raw('SUM(CASE categories.id when 1 then groups.age_from end) as sm_from'),
                DB::raw('SUM(CASE categories.id when 1 then groups.age_till end) as sm_till'),
                DB::raw('SUM(CASE categories.id when 2 then groups.age_from end) as md_from'),
                DB::raw('SUM(CASE categories.id when 2 then groups.age_till end) as md_till'),
                DB::raw('SUM(CASE categories.id when 3 then groups.age_from end) as lg_from'),
                DB::raw('SUM(CASE categories.id when 3 then groups.age_till end) as lg_till'),
                DB::raw('SUM(CASE categories.id when 4 then groups.age_from end) as nn_from'),
                DB::raw('SUM(CASE categories.id when 4 then groups.age_till end) as nn_till')
            ])
            ->whereIn('groups.id', $this->groups())
            ->groupBy('title', 'specialty')
            ->get();

        // set filename
        $filename = Auth::user()->role_id == 3
            ? config('constants.reports')[6]['name'] . 'по сформированной группе'
            : config('constants.reports')[6]['name'] . 'по сформированным группам';

        // create empty template
        $word = new TemplateProcessor('reports/collectives.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' г.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' г.',
            'till'     => @getDMY($request['till']) . ' г.',
        ]);

        // styles for tables
        $cellRowSpan     = ['vMerge' => 'restart'];
        $cellRowContinue = ['vMerge' => 'continue'];
        $cellHCentered   = ['align' => 'center'];
        $borderDark      = ['borderColor' => '000000', 'borderSize' => 6];

        // create table
        $table = new Table($borderDark);

        foreach ($groups as $group)
        {
            $table->addRow();
            $table->addCell(null, $cellRowSpan)->addText('Название <w:br/>группы');
            $table->addCell(null, $cellRowSpan)->addText('Специализация');
            $table->addCell(null, $cellRowSpan)->addText('Кол-во <w:br/>человек <w:br/>в группе');
            $table->addCell(null, $cellRowSpan)->addText('Вид <w:br/>занятия');
            $table->addCell(null, $cellRowSpan)->addText('Кол-во <w:br/>занятий <w:br/>в неделю');
            $table->addCell(null, ['gridSpan' => 8])->addText('Категория группы', null, $cellHCentered);

            $table->addRow();
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, ['gridSpan' => 2])->addText('Младшая', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('Средняя', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('Старшая', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('-', null, $cellHCentered);

            $table->addRow();
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell()->addText('От', null, $cellHCentered);
            $table->addCell()->addText('До', null, $cellHCentered);
            $table->addCell()->addText('От', null, $cellHCentered);
            $table->addCell()->addText('До', null, $cellHCentered);
            $table->addCell()->addText('От', null, $cellHCentered);
            $table->addCell()->addText('До', null, $cellHCentered);
            $table->addCell()->addText('От', null, $cellHCentered);
            $table->addCell()->addText('До', null, $cellHCentered);

            $table->addRow();
            $table->addCell()->addText($group->title);
            $table->addCell()->addText($group->specialty);
            $table->addCell()->addText($group->seats, null, $cellHCentered);
            $table->addCell()->addText();
            $table->addCell()->addText($group->workload / 4 . ' ч', null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->sm_from) ? '-' : $group->sm_from, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->sm_till) ? '-' : $group->sm_till, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->md_from) ? '-' : $group->md_from, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->md_till) ? '-' : $group->md_till, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->lg_from) ? '-' : $group->lg_from, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->lg_till) ? '-' : $group->lg_till, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->nn_from) ? '-' : $group->nn_from, null, $cellHCentered);
            $table->addCell(1000)->addText(is_null($group->nn_till) ? '-' : $group->nn_till, null, $cellHCentered);

            $table->addRow();
            $table->addCell(null, ['gridSpan' => 12, 'borderColor' => 'FFFFFF', 'borderSize' => 6])->addText();
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function teachers(Request $request)
    {
        $teachers = DB::table('timetables')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->select([
                'timetables.is_replace as worker_id',
                'titles.name as group'
            ])
            ->whereIn('timetables.group_id', $this->groups())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('timetables.is_replace', 'titles.name')
            ->get();

        $groups = DB::table('timetables')
            ->join('workers', 'timetables.is_replace', 'workers.id')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->join('categories', 'groups.category_id', 'categories.id')
            ->select([
                'workers.id as worker_id',
                'titles.name as group',
                'categories.name as category',
                DB::raw('COUNT(timetables.id) as lessons')
            ])
            ->whereIn('timetables.group_id', $this->groups())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('workers.id', 'titles.name', 'categories.name')
            ->get();

        // set filename
        $filename = Auth::user()->role_id == 3
            ? config('constants.reports')[7]['name'] . 'руководителю клубного формирования'
            : config('constants.reports')[7]['name'] . 'руководителям клубных формировании';

        // create empty template
        $word = new TemplateProcessor('reports/teachers.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' г.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' г.',
            'till'     => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table = new Table(['borderColor' => '000000', 'borderSize' => 6]);

        $table->addRow();
        $table->addCell()->addText('Руководитель', ['bold' => true]);
        $table->addCell()->addText('Коллектив', ['bold' => true]);
        $table->addCell()->addText('Категории', ['bold' => true]);
        $table->addCell()->addText('Кол-во занятий', ['bold' => true], ['align' => 'center']);

        foreach ($teachers as $teacher)
        {
            $table->addRow();
            $table->addCell()->addText(@getShortFIO('worker', $teacher->worker_id));
            $table->addCell(3000)->addText($teacher->group);

            $category   = '';
            $workload   = '';

            foreach ($groups->where('group', $teacher->group) as $group)
            {
                    $category  .= $group->category . '<w:br/>';
                    $workload  .= $group->lessons . ' ч <w:br/>';
            }

            $table->addCell(2000)->addText($category);
            $table->addCell(2000)->addText($workload, null, ['align' => 'center']);
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function sales(Request $request)
    {
        $passes = DB::table('passes')
            ->join('groups', 'passes.group_id', '=', 'groups.id')
            ->join('titles', 'groups.title_id', '=', 'titles.id')
            ->join('categories', 'groups.category_id', '=', 'categories.id')
            ->join('members', 'passes.member_id', '=', 'members.id')
            ->select([
                'passes.id',
                'passes.member_id as member',
                'titles.name as group',
                'categories.name as category',
                'passes.from',
                'passes.till',
                'passes.cost',
                'passes.lessons',
                'passes.status',
                'passes.pay_date',
                'passes.month',
                'passes.year'
            ])
            ->whereIn('passes.group_id', $this->groups())
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->get();

        $money  = DB::table('passes')
            ->selectRaw('SUM(passes.cost) as amount')
            ->whereIn('group_id', $this->groups())
            ->where('status', 1)
            ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
            ->first()
            ->amount;

        // set filename
        $filename = config('constants.reports')[8]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/sales.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
            'count_passes' => $passes->count(),
            'count_money'  => $money . ' ₽'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('№ <w:br/>абонемента', $fontText);
        $table->addCell()->addText('Дата начала действия', $fontText);
        $table->addCell()->addText('Дата окончания действия', $fontText);
        $table->addCell()->addText('Стоимость оплаченная за абонемент', $fontText);
        $table->addCell()->addText('Кол-во занятий', $fontText);
        $table->addCell()->addText('Кол-во посещений', $fontText);
        $table->addCell()->addText('Дата оплаты', $fontText);

        foreach ($passes as $index => $pass) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $pass->member));
            $table->addCell()->addText($pass->group);
            $table->addCell()->addText($pass->category);
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getDMY($pass->from));
            $table->addCell()->addText(@getDMY($pass->till));
            $table->addCell()->addText($pass->cost . ' ₽');
            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText(@getVisitsByType(Member::where('id', $pass->member)->first(), $pass->month, $pass->year, [1]));
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : __('_record.no'));
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs('Отчет по количеству проданных абонементов.docx');

        return response()->download('Отчет по количеству проданных абонементов.docx')->deleteFileAfterSend(true);
    }

    public function cashback(Request $request)
    {
        $apps = Application::whereIn('group_id', $this->groups())
            ->where('topic', 0)
            ->where('status', 1)
            ->whereBetween('updated_at', [$request['from'], $request['till']])
            ->get();

        // set filename
        $filename = config('constants.reports')[9]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/cashback.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Дата возврата', $fontText);
        $table->addCell()->addText('Причина возврата', $fontText);
        $table->addCell()->addText('Кол-во пропущенных занятий', $fontText);
        $table->addCell()->addText('Сумма возврата', $fontText);

        foreach ($apps as $index => $app)
        {
            $member         = Member::where('id', $app->member_id)->first();
            $count_miss     = @getVisitsByType($member, $app->pass->month, $app->pass->year, [2]);
            $pricePerLesson = $app->pass->cost / $app->pass->lessons;
            $cashback       = $count_miss * $pricePerLesson - 30;

            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $app->member_id));
            $table->addCell()->addText(@getDMY($app->updated_at));
            $table->addCell()->addText($app->desc);
            $table->addCell()->addText($count_miss);
            $table->addCell()->addText($cashback . ' ₽');
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function remains(Request $request)
    {
        $passes = Pass::whereIn('group_id', $this->groups())
            ->where('status', 1)
            ->whereBetween('pay_date', [$request['from'], $request['till']])
            ->get();

        // set filename
        $filename = config('constants.reports')[10]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/remains.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('№ <w:br/>абонемента', $fontText);
        $table->addCell()->addText('Кол-во оставшихся занятий', $fontText);

        foreach ($passes as $pass)
        {
            $member = Member::where('id', $pass->member_id)->first();
            $diff   = $pass->lessons - @getVisitsByType($member, $pass->month, $pass->year, [0, 1, 2]);

            if ($diff > 0)
            {
                $table->addRow();
                $table->addCell()->addText(@getFIO('member', $pass->member_id));
                $table->addCell()->addText($pass->group->title->name);
                $table->addCell()->addText($pass->group->category->name);
                $table->addCell()->addText($pass->id);
                $table->addCell()->addText($diff);
            }
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function misses(Request $request)
    {
        $misses = DB::table('visits')
            ->join('timetables', 'visits.timetable_id', 'timetables.id')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->join('categories', 'groups.category_id', 'categories.id')
            ->select([
                'visits.member_id as member',
                'titles.name as group',
                'categories.name as category',
                DB::raw('COUNT(visits.id) as lessons')
            ])
            ->whereIn('timetables.group_id', $this->groups())
            ->whereIn('visits.status', [0, 2])
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('visits.member_id', 'titles.name', 'categories.name')
            ->orderBy('categories.name')
            ->get();

        $count_misses = DB::table('visits')
            ->join('timetables', 'visits.timetable_id', 'timetables.id')
            ->selectRaw('COUNT(visits.id) as misses')
            ->whereIn('timetables.group_id', $this->groups())
            ->whereIn('visits.status', [0, 2])
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->first()
            ->misses;

        // set filename
        $filename = config('constants.reports')[13]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/misses.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
            'count_misses' => $count_misses,
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО участника', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('Кол-во пропущенных занятий', $fontText);

        foreach ($misses as $index => $miss)
        {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $miss->member));
            $table->addCell()->addText($miss->group);
            $table->addCell()->addText($miss->category);
            $table->addCell()->addText($miss->lessons);
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function workloads(Request $request)
    {
        // TODO: replace workers fix
        $loads = DB::table('timetables')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->join('categories', 'groups.category_id', 'categories.id')
            ->join('methods', 'timetables.method_id', 'methods.id')
            ->join('lessons', 'methods.lesson_id', 'lessons.id')
            ->select([
                'titles.name as group',
                'categories.name as category',
                'lessons.sign as type_lesson',
                DB::raw('COUNT(timetables.id) as hours')
            ])
            ->whereNotNull('timetables.method_id')
            ->whereIn('timetables.is_replace', @getWorkersID())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('titles.name', 'categories.name', 'lessons.sign')
            ->get();

        $workers = DB::table('timetables')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->select([
                'timetables.is_replace as worker_id',
                'titles.name as group'
            ])
            ->whereNotNull('timetables.method_id')
            ->whereIn('timetables.is_replace', @getWorkersID())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('timetables.is_replace', 'titles.name')
            ->get();

         $count_lessons = DB::table('timetables')
            ->selectRaw('COUNT(timetables.id) as hours')
            ->whereNotNull('timetables.method_id')
            ->whereIn('timetables.is_replace', @getWorkersID())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->first()
            ->hours;


        // set filename
        $filename = config('constants.reports')[12]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/workloads.docx');

        // set title of report
        $word->setValues([
            'title'         => $filename,
            'position'      => @getPosition(),
            'year'          => @getNowYear() . ' г.',
            'worker'        => @getAuthorOfReport(Auth::user()->worker),
            'from'          => @getDMY($request['from']) . ' г.',
            'till'          => @getDMY($request['till']) . ' г.',
            'count_lessons' => $count_lessons
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
        $table->addCell()->addText('ФИО руководителя', $fontText);
        $table->addCell()->addText('Название группы', $fontText);
        $table->addCell()->addText('Категория', $fontText);
        $table->addCell()->addText('Вид занятий', $fontText);
        $table->addCell()->addText('Кол-во занятий', $fontText);

        foreach ($workers as $index => $worker)
        {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getShortFIO('worker', $worker->worker_id));
            $table->addCell()->addText($worker->group);

            $category = '';
            $types    = '';
            $hours    = '';

            foreach ($loads->where('group', $worker->group) as $load)
            {
                $category .= $load->category . '<w:br/>';
                $types    .= $load->type_lesson . '<w:br/>';
                $hours    .= $load->hours . '<w:br/>';
            }

            $table->addCell()->addText($category, null, ['align' => 'center']);
            $table->addCell()->addText($types, null, ['align' => 'center']);
            $table->addCell()->addText($hours, null, ['align' => 'center']);
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function rooms(Request $request)
    {
        // set filename
        $filename = config('constants.reports')[11]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/rooms.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

//        $table->addRow();
//        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
//        $table->addCell()->addText('ФИО участника', $fontText);
//        $table->addCell()->addText('Название группы', $fontText);
//        $table->addCell()->addText('Категория', $fontText);
//        $table->addCell()->addText('№ <w:br/>абонемента', $fontText);
//        $table->addCell()->addText('Кол-во оставшихся занятий', $fontText);

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function schedule(Request $request)
    {
        // set filename
        $filename = config('constants.reports')[14]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/schedule.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' г.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' г.',
            'till'         => @getDMY($request['till']) . ' г.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

//        $table->addRow();
//        $table->addCell()->addText('№ <w:br/>п/п', $fontText);
//        $table->addCell()->addText('ФИО участника', $fontText);
//        $table->addCell()->addText('Название группы', $fontText);
//        $table->addCell()->addText('Категория', $fontText);
//        $table->addCell()->addText('№ <w:br/>абонемента', $fontText);
//        $table->addCell()->addText('Кол-во оставшихся занятий', $fontText);

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
