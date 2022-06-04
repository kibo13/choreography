<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use App\Models\Pass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    // Отчет по гражданам (льготникам), которым положена скидка за абонемент
    public function privileges()
    {
        // get list of members
        $members = Member::whereIn('group_id', $this->groups())
            ->whereNotNull('discount_id')
            ->where('discount_id', '!=', 5)
            ->get();

        // set filename
        $filename = config('constants.reports')[0]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/privileges.docx');

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(500)->addText('№', $fontText);
        $table->addCell(3000)->addText('ФИО льготника', $fontText);
        $table->addCell(3000)->addText('Категория <w:br/>льготника', $fontText);
        $table->addCell(3000)->addText('Размер скидки', $fontText);
        $table->addCell(3000)->addText('Название документа <w:br/>подтверждающего скидку', $fontText);
        $table->addCell(3000)->addText('Стоимость абонемента <w:br/>со скидкой', $fontText);

        foreach ($members as $index => $member) {
            $document = $member->discount_note ? $member->discount_note : __('_record.no');
            $discount = $member->discount->size;
            $price    = $member->group->price;
            $cost     = $price - $price * $discount / 100;

            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $member->id));
            $table->addCell()->addText($member->discount->name);
            $table->addCell()->addText($discount . '%');
            $table->addCell()->addText($document);
            $table->addCell()->addText($cost . ' ₽');
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function passes($type)
    {
        // get list of passes
        switch ($type) {
            case 1:
                $filename = config('constants.reports')[1]['name'];
                $field    = 'Стоимость абонемента';
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
                        'passes.pay_date'
                    ])
                    ->whereIn('passes.group_id', $this->groups())
                    ->where('members.discount_id', null)
                    ->orWhere('members.discount_id', 5)
                    ->get();
                break;

            case 2:
                $filename = config('constants.reports')[2]['name'];
                $field    = 'Стоимость абонемента со скидкой';
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
                        'passes.pay_date'
                    ])
                    ->whereIn('passes.group_id', $this->groups())
                    ->where('members.discount_id', '!=', 5)
                    ->get();
                break;
        }

        // create empty template
        $word = new TemplateProcessor('reports/passes.docx');

        // set title of report
        $word->setValue('title', $filename);

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(1000)->addText('№ <w:br/>абонемента', $fontText);
        $table->addCell(3000)->addText('ФИО участника', $fontText);
        $table->addCell(3000)->addText('Название группы', $fontText);
        $table->addCell(3000)->addText('Категория', $fontText);
        $table->addCell(3000)->addText('Дата начала действия', $fontText);
        $table->addCell(3000)->addText('Дата окончания действия', $fontText);
        $table->addCell(3000)->addText($field, $fontText);
        $table->addCell(3000)->addText('Кол-во занятий', $fontText);
        $table->addCell(3000)->addText('Кол-во посещений', $fontText);
        $table->addCell(3000)->addText('Дата продажи', $fontText);

        foreach ($passes as $pass) {
            $table->addRow();
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getFIO('member', $pass->member));
            $table->addCell()->addText($pass->group);
            $table->addCell()->addText($pass->category);
            $table->addCell()->addText(@getDMY($pass->from));
            $table->addCell()->addText(@getDMY($pass->till));
            $table->addCell()->addText($pass->cost . ' ₽');
            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText($pass->lessons);
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : __('_record.no'));
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function amounts()
    {
        // get amounts only for paid passes
        $passes = Pass::whereIn('group_id', $this->groups())->where('status', 1)->get();

        // set filename
        $filename = config('constants.reports')[3]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/amounts.docx');

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(1000)->addText('№ <w:br/>абонемента', $fontText);
        $table->addCell(3000)->addText('ФИО участника', $fontText);
        $table->addCell(3000)->addText('Название группы', $fontText);
        $table->addCell(3000)->addText('Категория', $fontText);
        $table->addCell(3000)->addText('Специализация', $fontText);
        $table->addCell(3000)->addText('Дата продажи <w:br/>абонемента', $fontText);
        $table->addCell(3000)->addText('Стоимость оплаты <w:br/>за абонемент', $fontText);

        foreach ($passes as $pass) {
            $table->addRow();
            $table->addCell()->addText($pass->id);
            $table->addCell()->addText(@getFIO('member', $pass->member->id));
            $table->addCell()->addText($pass->group->title->name);
            $table->addCell()->addText($pass->group->category->name);
            $table->addCell()->addText($pass->group->title->specialty->name);
            $table->addCell()->addText($pass->pay_date ? @getDMY($pass->pay_date) : __('_record.no'));
            $table->addCell()->addText($pass->cost . ' ₽');
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }

    public function ages(Request $request)
    {
        if (Auth::user()->role_id != 3) {
            $request->session()->flash('warning', 'Данный отчет доступен только руководителю');
            return redirect()->back();
        }

        // get list of age categories of club members
        $members = Member::whereIn('group_id', $this->groups())->orderBy('age')->get();

        // set filename
        $filename = config('constants.reports')[4]['name'];

        // create empty template
        $word = new TemplateProcessor('reports/ages.docx');

        // create table
        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];

        $table->addRow();
        $table->addCell(500)->addText('№', $fontText);
        $table->addCell(3000)->addText('ФИО участника', $fontText);
        $table->addCell(2000)->addText('Возраст', $fontText);
        $table->addCell(3000)->addText('Название группы', $fontText);
        $table->addCell(3000)->addText('Категория группы', $fontText);
        $table->addCell(3000)->addText('ФИО руководителя', $fontText);

        foreach ($members as $index => $member) {
            $table->addRow();
            $table->addCell()->addText(++$index);
            $table->addCell()->addText(@getFIO('member', $member->id));
            $table->addCell()->addText($member->age);
            $table->addCell()->addText($member->group->title->name);
            $table->addCell()->addText($member->group->category->name);
            $table->addCell()->addText(@getFIO('worker', Auth::user()->worker->id));
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename . '.docx');

        return response()->download($filename . '.docx')->deleteFileAfterSend(true);
    }
}
