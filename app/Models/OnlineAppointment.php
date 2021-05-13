<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use Illuminate\Support\Arr;

class OnlineAppointment extends Model
{

    protected $table = 'online_appointments';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $appends = ['monthNumber', 'rowsMerge'];
    protected $fillable = [
        'bike_id',
        'date_record',
        'text',
        'time_from',
        'time_to',
        'day_of_week'
    ];

    public function getAppointments($year, $month = '')
    {

        if (!empty($month)) {
            $onlineAppointments = OnlineAppointment::with('bike')->whereYear('date_record', '=', $year)
                ->whereMonth('date_record', '=', $month)
//                ->groupBy('date_record')
                ->orderBy('date_record', 'asc')
                ->get();

            return $onlineAppointments;

        }
        $onlineAppointments = OnlineAppointment::with('bike')->whereYear('date_record', '=', $year)
//            ->groupBy('date_record')
            ->orderBy('date_record', 'asc')
            ->get();
        return $onlineAppointments;
    }

    public function bike()
    {
        return $this->belongsTo(Bike::class, 'bike_id');
    }

    function getMonthName($monthNumber)
    {
        return date("F", mktime(0, 0, 0, $monthNumber, 1));
    }

    public function getYears()
    {
        $result = OnlineAppointment::select(\DB::raw('YEAR(date_record) as year'))->distinct()->get();

        if (count($result) < 1) {
            $years = date('Y');
            return array($years);
        }

        $years = $result->pluck('year');
        return $years;
    }

    public function getMonths($year)
    {
        $result = OnlineAppointment::select(\DB::raw('MONTH(date_record) as month'))
            ->distinct()
            ->whereYear('created_at', '=', $year)->get();

        if (count($result) < 1) {
            $date = new \DateTime('now');
            $monthNext = $date->modify('+1 month')->format('m');
            $monthsTemp = array(date('m'), $monthNext);

            $collection = collect($monthsTemp);
            $months = $collection->transform(function ($monthNumber, $key) use ($year) {

                return [
                    'year' => $year,
                    'number' => str_pad($monthNumber, 2, "0", STR_PAD_LEFT),
                    'name' => $this->getMonthName($monthNumber)];
            });
            return $months;
        }

        $monthsTemp = $result->pluck('month');
        $collection = collect($monthsTemp);

        $months = $collection->transform(function ($monthNumber, $key) use ($year) {

            return [
                'year' => $year,
                'number' => str_pad($monthNumber, 2, "0", STR_PAD_LEFT),
                'name' => $this->getMonthName($monthNumber)];
        });

        ///Берем из массива последний индекс и последний сформированный месяц
        $lastMonthIndex = (int)count($months) - 1;
        $lastMonth = $months[$lastMonthIndex];

//        if ($lastMonth['number'] ==11){
            $dateTemp = $lastMonth['year'] . '-' . $lastMonth['number'] . '-01';
            $dateFormat = strtotime($dateTemp);

            $date = date('Y-m-d', strtotime('+1 month', $dateFormat));
            $month = array(
                'year' => date('Y', strtotime($date)),
                'number' => date('m', strtotime($date)),
                'name' => $this->getMonthName(date('m', strtotime($date)))
            );
            $months->push($month);
//        }


        return $months;
    }


    public function getCountBikes()
    {
        $purchases = DB::table("bikes")
            ->select(DB::raw("SUM(count) as count"))->get()->first();
        return (int)$purchases->count;
    }

    public function getAllDayInMonth($year, $month = '')
    {
        $date = $year . '-' . $month . '-01';
        $end = $year . '-' . $month . '-' . date('t', strtotime($date)); //get end date of month

        $days = array();
        $i = 0;


        while (strtotime($date) <= strtotime($end)) {
            $dayNum = date('d', strtotime($date));
            $dayName = date('l', strtotime($date));
            $monthNumber = date('m', strtotime($date));


            $days[$i]['id'] = $i + 1;

            $dateRecord = $year . '-' . $monthNumber . '-' . $dayNum;
            $dateRecordAndTime = $dateRecord . " 00:00:00";
            $days[$i]['day_num'] = $this->getDayOfWeekNumber($date);
            $days[$i]['day_name'] = $this->getDayOfWeek($date);
            $days[$i]['date_record'] = $dateRecord;
            $days[$i]['date_record_time'] = $dateRecordAndTime;
            $days[$i]['date'] = $this->getDateAppointment($date);

            $bikes = Bike::orderBy('position', 'asc')->get();
            $days[$i]['bikes'] = $bikes;
            $days[$i]['countBikes'] = count($bikes);

            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $i++;
        }
        return $days;

    }


//    public function getYears(){
//        $result = OnlineAppointment::select(\DB::raw('YEAR(date_record) as year'))->distinct()->get();
//        $years = $result->pluck('year');
//        return $years;
//    }
//    public function getMonths($year){
//        $result =  OnlineAppointment::select(\DB::raw('MONTH(date_record) as month'))
//            ->distinct()
//            ->whereYear('created_at', '=', $year)->get();
//        $monthsTemp = $result->pluck('month');
//        $collection = collect($monthsTemp);
//        $months = $collection->transform(function ($monthNumber, $key) use($year) {
//
//            return [
//                'year' => $year,
//                'number' => $monthNumber,
//                'name' =>  $this->getMonthName($monthNumber)];
//        });
//        return $months;
//    }

    //Получить день и месяц
    public function getDateAppointment($date)
    {

        return Date::parse($date)->format('j F');

    }

    public function getRowsMergeAttribute()
    {

        return $dayOfWeekNumber = OnlineAppointment::with('bike')
            ->where('date_record', $this->date_record)->groupBy('date_record')
            ->get(array(

                DB::raw('Date(date_record) as date'),
                DB::raw('count(date_record) as "count"')
            ))->first();
//        return $dayOfWeekNumber;


    }

    //Получить день недели
    public function getDayOfWeek($date)
    {
        $days = array(
            'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
            'Четверг', 'Пятница', 'Суббота'
        );
        return $days[Date::parse($date)->format('w')];

    }

    public function getDayOfWeekNumber($date)
    {
        return (int)Date::parse($date)->format('w');
    }

    public function getMonthNumberAttribute()
    {
        return (int)Date::parse($this->date_record)->format('m');

    }
}
