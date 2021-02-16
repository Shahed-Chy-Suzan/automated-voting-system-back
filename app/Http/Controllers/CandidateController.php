<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index()
    {
        $candidate = DB::table('candidates')
                ->join('positions','candidates.position_id','positions.id')
                ->get();
        return response()->json($candidate,200);
    }

    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'channel'=>'required|unique:bus_drivers,channel',
        //     'plate_no'=>'required|unique:bus_drivers,busId',
        //     'driver_name'=>'required|unique:bus_drivers,driverId',
        //     'driving_status'=>'required',
        //     'startDate'=>'required'
        // ]);

        // $busDriver = New Candidate();
        // $busDriver->channel = $request->channel;
        // $busDriver->busId = $request->plate_no;
        // $busDriver->driverId = $request->driver_name;
        // $busDriver->driving_status = $request->driving_status;
        // $busDriver->startDate = $request->startDate;
        // $busDriver->save();
    }

    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    public function destroy(Candidate $candidate)
    {
        //
    }
}
