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
                ->select('candidates.*')
                ->get();
        return response()->json($candidate,200);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'position_id'=>'required',
            'age'=>'required|numeric'
        ]);

        $candidate = New Candidate();
        $candidate->name = $request->name;
        $candidate->position_id = $request->position_id;
        $candidate->age = $request->age;
        $candidate->team = $request->team;
        $candidate->save();
        return ['message'=>'OK', 'data' => $candidate];
    }

    public function update(Request $request, $id)
    {
        $candidate = Candidate::find($id);
        $candidate->name = $request->name;
        $candidate->position_id = $request->position_id;
        $candidate->age = $request->age;
        $candidate->team = $request->team;
        $candidate->save();
        return ['message'=>'OK', 'data' => $candidate];
    }

    public function destroy($id)
    {
        $candidate = Candidate::find($id);
        $candidate->delete();
    }
}
