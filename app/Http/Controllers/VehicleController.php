<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use DataTables;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*  $vehicles = Vehicle::get(); */
        $vehicles = Vehicle::onlyTrashed()->get();


        return view('vehicles.index', compact('vehicles'));
    }

    public function list(Request $request)
    {
        /*   $vehicles = Vehicle::latest()->get(); */

        if ($request->ajax()) {
            $data = Vehicle::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit"
                     class="edit btn btn-primary btn-sm editVehicle">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete"
                    class="btn btn-danger btn-sm deleteVehicle">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('vehicles.index', compact('vehicles'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*   $vehicles = Vehicle::all();

        return view('vehicles.create', compact('vehicles')); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function vehicleRegistration()
    {
        $plate_number =  ('[A-Z]{2}-[0-9]{5}');
    }
    public function store(Request $request)
    {


        Vehicle::updateOrCreate(
            ['id' => $request->vehicle_id],
            ['brand' => $request->brand, 'model' => $request->model, 'plate_number' => $request->plate_number, 'date' => $request->date]
        );


        return response()->json(['success' => 'Vehicle saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return Vehicle::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleRequest $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $input = $request->all();

        $brand = $request->input('brand');
        $model = $request->input('model');
        $plate_number = $request->input('plate_number');
        $date = $request->input('date');

        $vehicle->update($input);

        return redirect()->route('vehicle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vehicle::find($id)->delete();

        return response()->json(['success' => 'Vehicle deleted successfully.']);
    }
}
