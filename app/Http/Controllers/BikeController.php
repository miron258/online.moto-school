<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BikeRequest;
use App\Models\Bike;
use Illuminate\Http\Request;


class BikeController extends Controller
{

    public $bikes;
    public function __construct(){
        $this->bikes =  Bike::orderBy('position', 'asc')->get();
    }


    public function index(Request $request)
    {
        $bikes = $this->bikes;




//
        if ($request->ajax()) {
//            dd($request);
            return response()->json([
                'success' => true,
                'bikes' => $bikes,
                'message' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Список мотоциклов успешно получен</div>',
            ], 200);

        }

        return response()->view('bike.index', compact('bikes'));

    }


    public function create(BikeRequest $request)
    {


    }


    public function store(BikeRequest $request)
    {
        $params = $request->all(); //Все данные с инпутов формы

        $bike = new Bike();
        $nameBike = (empty($params['name'])) ? $params['name'] : $params['name'];
        $bike->name = $nameBike;
        $bike->position = (empty($params['position'])) ? $params['position'] : $params['position'];
        $bike->save();

        if ($bike) {
            return response()->json([
                'success' => true,
                'bikes' => $this->bikes,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Мотоцикл ' . $nameBike . ' успешно создан</div>',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'bikes' => array(),
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось создать мотоцикл ' . $nameBike . '!</div>',
        ], 200);


    }


    public function show()
    {

    }


    public function edit($id)
    {

        $bike = Bike::where('id', (int)$id)->get()->first();

        if (!empty($bike)){
            return response()->json([
                'success' => true,
                'bikes' => $this->bikes,
                'bike' => $bike,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Данные мотоцикла ' .$bike->name . ' успешно получены!</div>',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'bikes' => Bike::get(),
            'bike' => null,
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось получить данные мотоцикла!</div>',
        ], 200);

    }


    public function update(BikeRequest $request, $id)
    {

        $params = $request->all(); //Все данные с инпутов формы

        $bike = Bike::find($id);
        $nameBike = (empty($params['name'])) ? $params['name'] : $params['name'];
        $bike->name = $nameBike;
        $bike->position = (empty($params['position'])) ? $params['position'] : $params['position'];
        $bike->save();

        if ($bike) {
            return response()->json([
                'success' => true,
                'bike' => $bike,
                'bikes' => $this->bikes,
                'messageForm' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Мотоцикл ' . $nameBike . ' успешно обновлен</div>',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'bikes' => array(),
            'bike' => $bike,
            'messageForm' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось обновить мотоцикл ' . $nameBike . '!</div>',
        ], 200);


    }


    public function destroy($id)
    {
        $bike = Bike::where('id', $id)->get()->first();
        $bike->delete();

        if (!is_null($bike)) {
            return response()->json([
                'success' => true,
                'bikes' => $this->bikes,
                'message' => '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Мотоцикл ' . $bike->name . ' успешно удален</div>',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'bikes' => Bike::get(),
            'message' => '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>Не удалось удалить мотоцикл</div>',
        ], 200);
    }

}
