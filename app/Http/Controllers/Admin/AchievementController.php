<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class AchievementController extends Controller
{
    private function worker()
    {
        return Auth::user()->worker;
    }

    public function index()
    {
        switch (Auth::user()->role_id)
        {
            case 1:
            case 2:
            case 4:
                $worker = Worker::pluck('id');
                $events = Event::get();
                $years  = @getAchievementsByYears('ASC', $worker)->pluck('total', 'year')->keys();
                $total  = @getAchievementsByYears('ASC', $worker)->pluck('total', 'year')->values();
                break;

            case 3:
                $worker = Auth::user()->worker->id;
                $events = Event::where('worker_id', $worker)->get();
                $years  = @getAchievementsByYears('ASC', [$worker])->pluck('total', 'year')->keys();
                $total  = @getAchievementsByYears('ASC', [$worker])->pluck('total', 'year')->values();
                break;

            default:
                $events = [];
                $worker = null;
                $years  = [];
                $total  = [];
                break;
        }

        return view('admin.pages.achievements.index', [
            'events' => $events,
            'worker' => $worker,
            'years'  => $years,
            'total'  => $total
        ]);
    }

    public function create(Event $event)
    {
        return view('admin.pages.achievements.form', compact('event'));
    }

    public function store(Request $request)
    {
        Achievement::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.achievements.index');
    }

    public function show(Event $event)
    {
        $achievement = Achievement::where('event_id', $event->id)->first();

        return view('admin.pages.achievements.show', compact('achievement'));
    }

    public function edit(Event $event)
    {
        $achievement = Achievement::where('event_id', $event->id)->first();

        return view('admin.pages.achievements.form', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $achievement->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.achievements.index');
    }

    public function destroy(Request $request, Achievement $achievement)
    {
        $achievement->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.achievements.index');
    }

    public function report($year)
    {
        $filename = '?????????????? ?????????????? ???????????????????????? ?????? ?????? ?? ' . $year . '.docx';
        $word     = new TemplateProcessor('reports/achievements.docx');

        $word->setValues([
            'title'       => config('constants.reports')[0]['name'],
            'position'    => @getPosition(),
            'year'        => @getNowYear() . ' ??.',
            'select_year' => $year,
            'worker'      => @getAuthorOfReport(Auth::user()->worker)
        ]);

        $table    = new Table(['borderColor' => '000000', 'borderSize' => 6]);
        $fontText = ['bold' => true];
        $borderT  = ['borderTopColor' =>'FFFFFF', 'borderTopSize' => 6,];
        $borderB  = ['borderBottomColor' =>'FFFFFF', 'borderBottomSize' => 6,];
        $borderTB = [
            'borderTopColor'    =>'FFFFFF',
            'borderTopSize'     => 6,
            'borderBottomColor' =>'FFFFFF',
            'borderBottomSize'  => 6,
        ];

        $table->addRow();
        $table->addCell(500)->addText('???', $fontText);
        $table->addCell(5000)->addText('?????? ??????????????????', $fontText);
        $table->addCell(1000)->addText('???????????????????? ??????????????????', $fontText);
        $table->addCell(5000)->addText('???????????????? ???????????????? <w:br/>?????????????????? ??????????????', $fontText);
        $table->addCell(2000)->addText('???????????????? ????????????????????', $fontText);
        $table->addCell(3000)->addText('?????? ???????????????????????? ???????????????? ????????????????????????', $fontText);

        $achievements = Achievement::get();

        foreach ($achievements as $achievement)
        {
            $achievementYear = date('Y', strtotime($achievement->event->from));

            if ($achievementYear == $year) {

                foreach ($achievement->event->members as $index => $member)
                {
                    $table->addRow();
                    $table->addCell(500)->addText(++$index);
                    $table->addCell(5000)->addText(@getFIO('member', $member->id));
                    $table->addCell(1000)->addText($member->age . ' ??????');

                    switch ($index) {
                        case 1:
                            $table->addCell(1000, $borderB)->addText($achievement->event->name . ' <w:br/>' . $achievement->name);
                            $table->addCell(1000, $borderB)->addText($achievement->event->group->title->name . ' <w:br/>' . $achievement->event->group->category->name);
                            $table->addCell(1000, $borderB)->addText(@getFIO('worker', $achievement->event->worker->id));
                            break;

                        case count($achievement->event->members):
                            $table->addCell(5000, $borderT)->addText();
                            $table->addCell(2000, $borderT)->addText();
                            $table->addCell(3000, $borderT)->addText();
                            break;

                        default:
                            $table->addCell(5000, $borderTB)->addText();
                            $table->addCell(2000, $borderTB)->addText();
                            $table->addCell(3000, $borderTB)->addText();
                            break;
                    };
                }
            }
        }

        $word->setComplexBlock('table', $table);
        $word->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
