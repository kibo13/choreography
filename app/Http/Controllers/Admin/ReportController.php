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
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
            'count_passes' => $members->count(),
            'count_money'  => $money . ' ???'
        ]);

        // styles for tables
        $cellRowSpan     = ['vMerge' => 'restart'];
        $cellRowContinue = ['vMerge' => 'continue'];
        $cellHCentered   = ['align' => 'center'];

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(null, $cellRowSpan)->addText('???', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('?????? ??????????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('?????????????????? <w:br/>??????????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('???????????? ????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('???????????????? ?????????????????? <w:br/>?????????????????????????????? ????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('?????????? ????????????????????', $fontText);
        $table->addCell(null, ['gridSpan' => 2])->addText('???????????? ????????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('?????????????????? ????????????????????', $fontText);
        $table->addCell(null, $cellRowSpan)->addText('?????????? ???????????????????? <w:br/>???? ?????????????????? ???? ??????????????', $fontText);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(null, $cellRowContinue);
        $table->addCell(500)->addText('????????????', null, $cellHCentered);
        $table->addCell(500)->addText('??????????????????', null, $cellHCentered);
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
            $table->addCell()->addText('???' . $member->pass_id);
            $table->addCell()->addText(@getDMY($member->pass_from));
            $table->addCell()->addText(@getDMY($member->pass_till));
            $table->addCell()->addText($member->price . ' ???');
            $table->addCell()->addText($member->cost . ' ???');
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
                $money = DB::table('passes')
                    ->join('members', 'passes.member_id', '=', 'members.id')
                    ->selectRaw('SUM(passes.cost) as total_money')
                    ->whereIn('passes.group_id', $this->groups())
                    ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
                    ->where(function ($query) {
                        $query
                            ->whereNull('members.discount_id')
                            ->orWhere('members.discount_id', 5);
                    })
                    ->first()
                    ->total_money;
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
                $money = DB::table('passes')
                    ->join('members', 'passes.member_id', '=', 'members.id')
                    ->selectRaw('SUM(passes.cost) as total_money')
                    ->whereIn('passes.group_id', $this->groups())
                    ->whereBetween('passes.pay_date', [$request['from'], $request['till']])
                    ->where('members.discount_id', '!=', 5)
                    ->first()
                    ->total_money;
                break;
        }

        // create empty template
        $word = new TemplateProcessor('reports/passes.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
            'count_passes' => $passes->count(),
            'count_money'  => $money . ' ???'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??? <w:br/>????????????????????', $fontText);
        $table->addCell()->addText('???????? ???????????? ????????????????', $fontText);
        $table->addCell()->addText('???????? ?????????????????? ????????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????????', $fontText);

        if ($type == 1)
        {
            $table->addCell()->addText('?????????? ???????????????????? <w:br/>???? ??????????????????', $fontText);
        }

        else
        {
            $table->addCell()->addText('???????????? ?????????????????? ????????????????????', $fontText);
            $table->addCell()->addText('?????????? ???????????????????? <w:br/>???? ?????????????????? ???? ??????????????', $fontText);
        }


        $table->addCell()->addText('???????? ????????????', $fontText);

        foreach ($passes as $index => $pass) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $pass->member));
            $table->addCell()->addText($pass->group);
            $table->addCell()->addText($pass->category);
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getDMY($pass->from));
            $table->addCell()->addText(@getDMY($pass->till));
            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText(@getVisitsByType(Member::where('id', $pass->member)->first(), $pass->month, $pass->year, [1]));

            if ($type == 1)
            {
                $table->addCell()->addText($pass->cost . ' ???');
            }

            else
            {
                $table->addCell()->addText($pass->price . ' ???');
                $table->addCell()->addText($pass->cost . ' ???');
            }

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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
            'count_passes' => $passes->count(),
            'count_money'  => $money . ' ???'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??????????????????????????', $fontText);
        $table->addCell()->addText('???????? ?????????????? ????????????????????', $fontText);
        $table->addCell()->addText('?????????? ????????????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????????????', $fontText);
        $table->addCell()->addText('?????????? ???????????????????? ???? ??????????????????', $fontText);

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
            $table->addCell()->addText($pass->cost . ' ???');
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
            'year'     => @getNowYear() . ' ??.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' ??.',
            'till'     => @getDMY($request['till']) . ' ??.'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('???', $fontText);
        $table->addCell(7000)->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??????????????', $fontText);

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
            'year'     => @getNowYear() . ' ??.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' ??.',
            'till'     => @getDMY($request['till']) . ' ??.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(2000)->addText('?????????? ??????????????????????', $fontText);
        $table->addCell(2000)->addText('???????? ??????????????????????', $fontText);
        $table->addCell(2000)->addText('???????? ????????????  <w:br/>??????????????????', $fontText);
        $table->addCell(5000)->addText('???????????????? ??????????????????', $fontText);
        $table->addCell(3000)->addText('?????????????? ????????????????????', $fontText);
        $table->addCell(2000)->addText('?????? ??????????', $fontText);
        $table->addCell(3000)->addText('????????????????????', $fontText);

        foreach ($awards as $award) {
            $table->addRow();
            $table->addCell()->addText('???' . $award->num);
            $table->addCell()->addText(@getDMY($award->date_reg));
            $table->addCell()->addText(@getDMY($award->date_doc));
            $table->addCell()->addText($award->name_doc);
            $table->addCell()->addText('?????????? ???????????????????? <w:br/>' . $award->group->title->name . ' / ' . $award->group->category->name . '<w:br/>(' . $award->totalSeats() . ' ??????.)');
            $table->addCell()->addText('???????????????????????? ????????????????: <w:br/>' . $award->orgkomitet->name);
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
            ? config('constants.reports')[6]['name'] . '???? ???????????????????????????? ????????????'
            : config('constants.reports')[6]['name'] . '???? ???????????????????????????? ??????????????';

        // create empty template
        $word = new TemplateProcessor('reports/collectives.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' ??.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' ??.',
            'till'     => @getDMY($request['till']) . ' ??.',
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
            $table->addCell(null, $cellRowSpan)->addText('???????????????? <w:br/>????????????');
            $table->addCell(null, $cellRowSpan)->addText('??????????????????????????');
            $table->addCell(null, $cellRowSpan)->addText('??????-???? <w:br/>?????????????? <w:br/>?? ????????????');
            $table->addCell(null, $cellRowSpan)->addText('?????? <w:br/>??????????????');
            $table->addCell(null, $cellRowSpan)->addText('??????-???? <w:br/>?????????????? <w:br/>?? ????????????');
            $table->addCell(null, ['gridSpan' => 8])->addText('?????????????????? ????????????', null, $cellHCentered);

            $table->addRow();
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, ['gridSpan' => 2])->addText('??????????????', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('??????????????', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('??????????????', null, $cellHCentered);
            $table->addCell(null, ['gridSpan' => 2])->addText('-', null, $cellHCentered);

            $table->addRow();
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell(null, $cellRowContinue);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);
            $table->addCell()->addText('????', null, $cellHCentered);

            $table->addRow();
            $table->addCell()->addText($group->title);
            $table->addCell()->addText($group->specialty);
            $table->addCell()->addText($group->seats, null, $cellHCentered);
            $table->addCell()->addText();
            $table->addCell()->addText($group->workload / 4 . ' ??', null, $cellHCentered);
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
            ? config('constants.reports')[7]['name'] . '???????????????????????? ???????????????? ????????????????????????'
            : config('constants.reports')[7]['name'] . '?????????????????????????? ?????????????? ????????????????????????';

        // create empty template
        $word = new TemplateProcessor('reports/teachers.docx');

        // set title of report
        $word->setValues([
            'title'    => $filename,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' ??.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' ??.',
            'till'     => @getDMY($request['till']) . ' ??.',
        ]);

        // create table
        $table = new Table(['borderColor' => '000000', 'borderSize' => 6]);

        $table->addRow();
        $table->addCell()->addText('????????????????????????', ['bold' => true]);
        $table->addCell()->addText('??????????????????', ['bold' => true]);
        $table->addCell()->addText('??????????????????', ['bold' => true]);
        $table->addCell()->addText('??????-???? ??????????????', ['bold' => true], ['align' => 'center']);

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
                    $workload  .= $group->lessons . ' ?? <w:br/>';
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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
            'count_passes' => $passes->count(),
            'count_money'  => $money . ' ???'
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??? <w:br/>????????????????????', $fontText);
        $table->addCell()->addText('???????? ???????????? ????????????????', $fontText);
        $table->addCell()->addText('???????? ?????????????????? ????????????????', $fontText);
        $table->addCell()->addText('?????????????????? ???????????????????? ???? ??????????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????????', $fontText);
        $table->addCell()->addText('???????? ????????????', $fontText);

        foreach ($passes as $index => $pass) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $pass->member));
            $table->addCell()->addText($pass->group);
            $table->addCell()->addText($pass->category);
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getDMY($pass->from));
            $table->addCell()->addText(@getDMY($pass->till));
            $table->addCell()->addText($pass->cost . ' ???');
            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText(@getVisitsByType(Member::where('id', $pass->member)->first(), $pass->month, $pass->year, [1]));
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : __('_record.no'));
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs('?????????? ???? ???????????????????? ?????????????????? ??????????????????????.docx');

        return response()->download('?????????? ???? ???????????????????? ?????????????????? ??????????????????????.docx')->deleteFileAfterSend(true);
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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????? ????????????????', $fontText);
        $table->addCell()->addText('?????????????? ????????????????', $fontText);
        $table->addCell()->addText('??????-???? ?????????????????????? ??????????????', $fontText);
        $table->addCell()->addText('?????????? ????????????????', $fontText);

        foreach ($apps as $index => $app)
        {
            $cost           = $app->pass->cost;
            $pricePass      = 30;
            $lessonsLimit   = $app->pass->lessons;
            $lessonsExist   = @getVisitsByType($app->member, $app->pass->month, $app->pass->year, [0, 1]);
            $lessonsOver    = $lessonsLimit - $lessonsExist;
            $priceLesson    = $cost / $lessonsLimit;
            $cashback       = $lessonsOver * $priceLesson - $pricePass * $lessonsOver;

            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $app->member_id));
            $table->addCell()->addText(@getDMY($app->updated_at));
            $table->addCell()->addText($app->desc);
            $table->addCell()->addText($lessonsOver);
            $table->addCell()->addText($cashback . ' ???');
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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??? <w:br/>????????????????????', $fontText);
        $table->addCell()->addText('??????-???? ???????????????????? ??????????????', $fontText);

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
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
            'count_misses' => $count_misses,
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ??????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('??????-???? ?????????????????????? ??????????????', $fontText);

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
            'year'          => @getNowYear() . ' ??.',
            'worker'        => @getAuthorOfReport(Auth::user()->worker),
            'from'          => @getDMY($request['from']) . ' ??.',
            'till'          => @getDMY($request['till']) . ' ??.',
            'count_lessons' => $count_lessons
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('?????? ????????????????????????', $fontText);
        $table->addCell()->addText('???????????????? ????????????', $fontText);
        $table->addCell()->addText('??????????????????', $fontText);
        $table->addCell()->addText('?????? ??????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????????', $fontText);

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
        $loads = DB::table('timetables')
            ->join('rooms', 'timetables.room_id', 'rooms.id')
            ->join('methods', 'timetables.method_id', 'methods.id')
            ->join('lessons', 'methods.lesson_id', 'lessons.id')
            ->select([
                'rooms.num',
                'lessons.sign',
                DB::raw('COUNT(timetables.id) as hours')
            ])
            ->whereNotNull('timetables.method_id')
            ->whereIn('timetables.group_id', $this->groups())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('rooms.num', 'lessons.sign')
            ->get();

        $rooms = DB::table('timetables')
            ->join('rooms', 'timetables.room_id', 'rooms.id')
            ->select('rooms.num')
            ->whereNotNull('timetables.method_id')
            ->whereIn('timetables.group_id', $this->groups())
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('rooms.num')
            ->get();

        // set filename
        $filename = config('constants.reports')[11]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/rooms.docx');

        // set title of report
        $word->setValues([
            'title'        => $filename,
            'position'     => @getPosition(),
            'year'         => @getNowYear() . ' ??.',
            'worker'       => @getAuthorOfReport(Auth::user()->worker),
            'from'         => @getDMY($request['from']) . ' ??.',
            'till'         => @getDMY($request['till']) . ' ??.',
        ]);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell()->addText('??? <w:br/>??/??', $fontText);
        $table->addCell()->addText('??????????????', $fontText);
        $table->addCell()->addText('?????? ??????????????', $fontText);
        $table->addCell()->addText('??????-???? ??????????', $fontText);

        foreach ($rooms as $index => $room)
        {
            $table->addRow();
            $table->addCell(1000)->addText(++$index);
            $table->addCell(3000)->addText('?????????????? ???' . $room->num);

            $types = '';
            $hours = '';

            foreach ($loads->where('num', $room->num) as $load)
            {
                $types .= $load->sign . '<w:br/>';
                $hours .= $load->hours . ' ?? <w:br/>';
            }

            $table->addCell(3000)->addText($types, null, ['align' => 'center']);
            $table->addCell(3000)->addText($hours, null, ['align' => 'center']);
        }


        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function schedule(Request $request)
    {
        if ($request['title_id'])
        {
            $team        = Title::where('id', $request['title_id'])->first();
            $categories  = $team->groups->pluck('id');
        }

        else
        {
            $team       = Auth::user()->worker->groups->first()->title;
            $categories = $this->groups();
        }

        $days = DB::table('timetables')
            ->selectRaw('DATE(timetables.from) as date_from')
            ->whereIn('timetables.group_id', $categories)
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('date_from')
            ->orderBy('date_from')
            ->get();

        $groups = DB::table('timetables')
            ->join('groups', 'timetables.group_id', 'groups.id')
            ->join('titles', 'groups.title_id', 'titles.id')
            ->join('categories', 'groups.category_id', 'categories.id')
            ->select([
                'timetables.group_id',
                'titles.name as team',
                'categories.name as category',
            ])
            ->whereIn('timetables.group_id', $categories)
            ->whereBetween('timetables.from', [$request['from'], $request['till']])
            ->groupBy('timetables.group_id', 'titles.name', 'categories.name')
            ->get();

        $room = Group::whereIn('id', $categories)->first()->room->num;

        // set filename
        $filename = config('constants.reports')[14]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/schedule.docx');

        // set title of report
        $word->setValues([
            'team'     => $team->name,
            'position' => @getPosition(),
            'year'     => @getNowYear() . ' ??.',
            'worker'   => @getAuthorOfReport(Auth::user()->worker),
            'from'     => @getDMY($request['from']) . ' ??.',
            'till'     => @getDMY($request['till']) . ' ??.',
            'room'     => ' ???' . $room
        ]);

        // create table
        $table     = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $bgCell    = ['bgColor' => 'e0e0e0'];

        $table->addRow();
        $table->addCell(null, $bgCell)->addText('??????????????????');

        foreach ($days as $day)
        {
            $dayOfWeek = @getDMY($day->date_from) . '<w:br/>' . @getDayOfWeek($day->date_from);

            $table->addCell(null, $bgCell)->addText($dayOfWeek);
        }

        foreach ($groups as $group)
        {
            $table->addRow();
            $table->addCell()->addText($group->category);

            foreach ($days as $day)
            {
                $list    = '';
                $lessons = DB::table('timetables')
                    ->where('group_id', $group->group_id)
                    ->whereBetween('from', [$request['from'], $request['till']])
                    ->where(DB::raw('DATE(timetables.from)'), $day->date_from)
                    ->get();

                foreach ($lessons as $n => $lesson)
                {
                    $list .= ++$n . ' ?????????????? <w:br/>';
                    $list .= getHI($lesson->from) . '-' . getHI($lesson->till) . '<w:br/>';
                }

                $table->addCell()->addText($list);
            }
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
