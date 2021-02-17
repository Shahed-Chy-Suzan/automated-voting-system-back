<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::all();
        return response()->json($position);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:2|max:50',
        ]);
        $position = New Position();
        $position->name = $request->name;
        $position->save();
        return ['message'=>'OK', 'data' => $position];
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|min:2|max:50',
        ]);
        $position = Position::find($id);
        $position->name = $request->name;
        $position->save();
    }

    public function destroy($id)
    {
        $position = Position::find($id);
        $position->delete();
    }
}
