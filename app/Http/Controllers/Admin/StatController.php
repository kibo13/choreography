<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Charts\MasterChart;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    private function sales($group, $from, $till)
    {
        return DB::table('passes')
            ->select([
                DB::raw('DATE_FORMAT(passes.pay_date, \'%m.%Y\') as period'),
                DB::raw('COUNT(passes.id) as sales')
            ])
            ->where('passes.group_id', $group)
            ->whereBetween('passes.pay_date', [$from, $till])
            ->where('passes.status', 1)
            ->groupBy('period')
            ->get();
    }

    private function visits($group, $from, $till)
    {
        return DB::table('visits')
            ->join('timetables', 'visits.timetable_id', 'timetables.id')
            ->select([
                DB::raw('DATE_FORMAT(timetables.from, \'%m.%Y\') as period'),
                DB::raw('COUNT(visits.id) as visits')
            ])
            ->where('timetables.group_id', $group)
            ->whereBetween('timetables.from', [$from, $till])
            ->where('visits.status', 1)
            ->groupBy('period')
            ->get();
    }

    public function index(Request $request)
    {
        $initFrom = $request['from'] ? $request['from'] : '2021-09-01';
        $initTill = $request['till'] ? $request['till'] : '2022-06-30';
        $tempDate = $initFrom;
        $labels   = [];
        $groups   = Group::get();

        while ($tempDate < $initTill) {
            array_push($labels, date('m.Y', strtotime($tempDate)));
            $tempDate = date('Y-m-d', strtotime('+1 months', strtotime($tempDate)));
        }

        // filling chart by visits
        foreach ($groups as $group)
        {
            $getVisitsByGroup = $this->visits($group->id, $initFrom, $initTill);
            $getSalesByGroup  = $this->sales($group->id, $initFrom, $initTill);

            foreach ($labels as $label)
            {
                $visitLabels[$label] = 0;
                $saleLabels[$label]  = 0;

                foreach ($getVisitsByGroup as $visit)
                {
                    if ($visit->period == $label)
                    {
                        $visitLabels[$label] = $visit->visits;
                    }
                }

                foreach ($getSalesByGroup as $sale)
                {
                    if ($sale->period == $label)
                    {
                        $saleLabels[$label] = $sale->sales;
                    }
                }
            }

            $groupsOfVisits[$group->id] = $visitLabels;
            $groupsOfSales[$group->id]  = $saleLabels;
        }

        $chartOfVisits = new MasterChart;
        $chartOfVisits->labels($labels);
        foreach ($groupsOfVisits as $group_id => $gov)
        {
            $teamName = @getGroupNameByID($group_id)->title->name;
            $category = @getGroupNameByID($group_id)->category_id < 4 ? @getGroupNameByID($group_id)->category->name : '';
            $title    = $teamName . ' ' . $category;

            $chartOfVisits
                ->dataset($title, 'bar', array_values($gov))
                ->options([
                    'backgroundColor' => @getGroupNameByID($group_id)->color,
                    'borderColor' => 'transparent',
                ]);
        }

        $chartOfSales  = new MasterChart;
        $chartOfSales->labels($labels);
        foreach ($groupsOfSales as $group_id => $gos)
        {
            $teamName = @getGroupNameByID($group_id)->title->name;
            $category = @getGroupNameByID($group_id)->category_id < 4 ? @getGroupNameByID($group_id)->category->name : '';
            $title    = $teamName . ' ' . $category;

            $chartOfSales
                ->dataset($title, 'bar', array_values($gos))
                ->options([
                    'backgroundColor' => @getGroupNameByID($group_id)->color,
                    'borderColor' => 'transparent',
                ]);
        }

        return view('admin.pages.stats.index', [
            'chart_visits' => $chartOfVisits,
            'chart_sales'  => $chartOfSales,
        ]);
    }
}
