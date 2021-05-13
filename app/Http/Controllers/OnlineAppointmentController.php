<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnlineAppointmentRequest;
use App\Models\Bike;
use App\Models\OnlineAppointment;
use Illuminate\Http\Request;

class OnlineAppointmentController extends Controller
{

    public $bikes;
    public $appointments;
    public $appointment;

    function __construct(Request $request)
    {


        $this->appointment = new OnlineAppointment();
        $this->bikes = Bike::orderBy('position', 'asc')->get();

    }


    public function index(Request $request)
    {


        $bikes = $this->bikes;
        if ($request->ajax()) {
            $params = request()->all();


            $years = $this->appointment->getYears();
            $months = $this->appointment->getMonths($params['year']);
            $days = $this->appointment->getAllDayInMonth($params['year'], $params['month']);


            if (!empty($params['month'])) {
                $appointments = $this->appointment->getAppointments($params['year'], $params['month']);
            } else {
                $appointments = $this->appointment->getAppointments($params['year']);
            }
            return response()->json([
                'success' => true,
                'bikes' => $bikes,
                'years' => $years,
                'months' => $months,
                'days'=> $days,
                'appointments' => $appointments,
                'message' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Список онлайн-записей успешно получен</div>',
            ], 200);

        }
        return response()->view('online_appointment.index', compact('bikes'));

    }

    public function create()
    {

    }


    public function store(OnlineAppointmentRequest $request)
    {
        $params = $request->all(); //Все данные с инпутов формы

        $appointment = new OnlineAppointment();
        $nameAppointment = (empty($params['text'])) ? $params['text'] : $params['text'];
        $appointment->text = $nameAppointment;
        $appointment->date_record = (empty($params['date_record'])) ? $params['date_record'] : $params['date_record'];
        $appointment->bike_id = (empty($params['bike_id'])) ? $params['bike_id'] : $params['bike_id'];
        $appointment->status = (empty($params['status'])) ? $params['status'] : $params['status'];
        $appointment->phone = (empty($params['phone'])) ? $params['phone'] : $params['phone'];
        $appointment->time_from = (empty($params['time_from'])) ? $params['time_from'] : $params['time_from'];
        $appointment->time_to = (empty($params['time_to'])) ? $params['time_to'] : $params['time_to'];

        $appointment->save();

        $years = $this->appointment->getYears();
        $months = $this->appointment->getMonths($params['year']);
        $days = $this->appointment->getAllDayInMonth($params['year'], $params['month']);


        if (!empty($params['month'])) {
            $appointments = $this->appointment->getAppointments($params['year'], $params['month']);
        } else {
            $appointments = $this->appointment->getAppointments($params['year']);
        }


        if ($appointment) {

            return response()->json([
                'success' => true,
                'years' => $years,
                'months' => $months,
                'days'=> $days,
                'appointments' => $appointments,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Онлайн-запись ' . $nameAppointment . ' успешно создана</div>',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'years' => $years,
            'months' => $months,
            'appointments' => $appointments,
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось создать онлайн-запись ' . $nameAppointment . '!</div>',
        ], 200);
    }


    public function show()
    {

    }


    public function edit($id, Request $request)
    {



        $appointment = OnlineAppointment::with('bike')->where('id', (int)$id)->get()->first();

        if (!empty($appointment)) {
            $params = $request->all();


            $years = $this->appointment->getYears();
            $months = $this->appointment->getMonths($params['year']);
            if (!empty($params['month'])) {
                $appointments = $this->appointment->getAppointments($params['year'], $params['month']);
            } else {
                $appointments = $this->appointment->getAppointments($params['year']);
            }


            return response()->json([
                'success' => true,
                'appointments' => $appointments,
                'bikes' => $this->bikes,
                'years' => $years,
                'months' => $months,
                'appointment' => $appointment,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Данные онлайн записи ' . $appointment->text . ' успешно получены!</div>',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'appointments' => array(),
            'appointment' => null,
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось получить данные онлайн-записи!</div>',
        ], 200);
    }


    public function update(OnlineAppointmentRequest $request, $id)
    {
        $params = $request->all(); //Все данные с инпутов формы


        $appointment = OnlineAppointment::with('bike')->find($id);
        $nameAppointment = (empty($params['text'])) ? $params['text'] : $params['text'];
        $appointment->text = $nameAppointment;

        $appointment->date_record = (empty($params['date_record'])) ? $params['date_record'] : $params['date_record'];
        $appointment->bike_id = (empty($params['bike_id'])) ? $params['bike_id'] : $params['bike_id'];
        $appointment->status = (empty($params['status'])) ? $params['status'] : $params['status'];
        $appointment->phone = (empty($params['phone'])) ? $params['phone'] : $params['phone'];
        $appointment->time_from = (empty($params['time_from'])) ? $params['time_from'] : $params['time_from'];
        $appointment->time_to = (empty($params['time_to'])) ? $params['time_to'] : $params['time_to'];
        $appointment->save();

        $years = $this->appointment->getYears();
        $months = $this->appointment->getMonths($params['year']);
        $days = $this->appointment->getAllDayInMonth($params['year'], $params['month']);


        if (!empty($params['month'])) {
            $appointments = $this->appointment->getAppointments($params['year'], $params['month']);
        } else {
            $appointments = $this->appointment->getAppointments($params['year']);
        }


        if ($appointment) {

            return response()->json([
                'success' => true,
                'appointment' => $appointment,
                'years' => $years,
                'months' => $months,
                'days' => $days,
                'appointments' => $appointments,
                'bikes' => $this->bikes,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Онлайн запись ' . $nameAppointment . ' успешно обновлена</div>',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'years' => $years,
            'months' => $months,
            'appointments' => $appointments,
            'appointment' => $appointment,
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось обновить онлайн запись ' . $nameAppointment . '!</div>',
        ], 200);
    }


    public function destroy($id, Request $request)
    {
        $appointment = OnlineAppointment::where('id', $id)->get()->first();
        $appointment->delete();


        $params = $request->all();
        $years = $this->appointment->getYears();
        $months = $this->appointment->getMonths($params['year']);
        $days = $this->appointment->getAllDayInMonth($params['year'], $params['month']);


        if (!empty($params['month'])) {
            $appointments = $this->appointment->getAppointments($params['year'], $params['month']);
        } else {
            $appointments = $this->appointment->getAppointments($params['year']);
        }

        if (!is_null($appointment)) {

            return response()->json([
                'success' => true,
                'appointments' => $appointments,
                'years' => $years,
                'days' => $days,
                'months' => $months,
                'message' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Онлайн-запись ' . $appointment->text . ' успешно удалена</div>',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'appointments' => $appointments,
            'years' => $years,
            'months' => $months,
            'message' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось удалить онлайн-запись</div>',
        ], 200);
    }

}
