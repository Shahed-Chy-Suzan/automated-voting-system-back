<?php

namespace App\Http\Controllers;

use App\User;
use App\Voter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $voters = Voter::all();

        return ['message'=>'OK', 'data' => $voters];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'voter_name'=>'required|min:2|max:50',
            'age'=>'numeric',
            'nid'=>'required|numeric',
            'finger_print_id'=>'',
        ]);

        $userData = new User();
        $userData->name = $request->voter_name;
        $userData->username = $request->nid;
        $userData->password = $request->nid;;
        $userData->save();

        $voterData = new Voter();
        $voterData->user_id = $userData->id;
        $voterData->voter_name = $request->voter_name;
        $voterData->age = $request->age;
        $voterData->nid = $request->nid;
        $voterData->finger_print_id = $request->finger_print_id;
        $voterData->save();

        return ['message'=>'OK', 'data' => $voterData];
    }

    public function update(Request $request, Voter $voter)
    {
        //
    }

    public function destroy($id)
    {
        $voterData = Voter::find($id);
        $voterData->delete();
    }
}
