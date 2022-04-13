<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::with("cars")->get();
        return \response($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|Application|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        User::create($request->all());
        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->apartment_no = $request->apartment_no;
        $user->save();

        return response([
            "data" => $user,
            "message" => "User created."
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return Application|ResponseFactory|Response
     */
    public function show($id)
    {
        $users = User::find($id);
        if ($users) {
            return \response($users, 200);
        } else
            return \response(["message" => "Bulunamadı."]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->apartment_no = $request->apartment_no;
        $user->save();

        return response([
            "data" => $user,
            "message" => "Car updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \response(["message" => "Kullanıcı silindi."]);
    }
}
