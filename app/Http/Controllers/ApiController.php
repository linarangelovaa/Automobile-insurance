<?php

namespace App\Http\Controllers;

use Carbon\Factory;
use App\Models\User;
use App\Models\Vehicle;
use Faker\Provider\Fakecar;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VehicleRequest;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            /*  return response()->json(['token' => $user->createToken('api-token')->plainTextToken]); */
            return redirect()->route('vehicles.index');
        }
        return response()->json(['error' => 'Login failed!'], 401);
    }

    public function index()
    {
        return response()->json(['posts' => Vehicle::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $vehicle = new Vehicle();
        $vehicle->model = $request->model;
        $vehicle->brand = $request->brand;
        $vehicle->plate_number = $request->plate_number;
        $vehicle->date = $request->date;
        $vehicle->save();

        return response($vehicle, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json([$vehicle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {

        $vehicle->delete();

        return response()->json(null, 204);
    }
}
