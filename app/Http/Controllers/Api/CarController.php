<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use http\Env\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class  CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
//        return response(Car::all(), 200);
        $searchQuery = $request->query("user_id");
        $posts = Car::query()->where("user_id", 'LIKE', $searchQuery)->take(10)->get();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $car_count = Car::where("user_id", $request->get("user_id"))->count();
        if ($car_count >= 3) {
            return response("Maksimum araç sayısına sahipsiniz.");
        }
        echo "Araç Sayısı = " . $car_count;
        Car::create([
            "plaque_number" => $request->get('plaque_number'),
            "user_id" => $request->get("user_id")
        ]);
        return response(["message" => "Yeni araç eklenmiştir."]);
    }


    /**
     * Display the specified resource.
     *
     * @param Car $car
     * @return Application|\Illuminate\Http\Response|ResponseFactory
     */
    public function show($id)
    {
        $cars = Car::find($id);
        if ($cars) {
            return \response($cars, 200);
        } else
            return \response(["message" => "Bulunamadı."]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Car $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $car->plaque_number = $request->plaque_number;
        $car->user_id = $request->user_id;
        $car->save();

        return response([
            "data" => $car,
            "message" => "Car updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Car $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return \response(["message" => "Araç Silindi."]);
    }

    public function getCarById()
    {

    }
}
