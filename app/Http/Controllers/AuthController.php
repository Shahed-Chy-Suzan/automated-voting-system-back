<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;    //-----------
use DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);      //------was default------
        // $this->middleware('auth:api', ['except' => ['login','signup']]);     //-------------
        $this->middleware('JWT', ['except' => ['login','signup']]);     //-------------
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'user_name' => ['required', 'min:4', 'string', 'max:255'],
            'finger_print_id' => ['required', 'min:4'],
        ]);

        $credentials = request(['user_name', 'finger_print_id']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'User or Finger Print field is Invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    public function signup(Request $request)    //---------------------------
    {
        $validateData = $request->validate([
            'voter_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'numeric'],
            'nid' => ['required', 'min:4', 'unique:users'],
            'user_name' => ['required', 'min:4', 'string', 'max:255'],
            'finger_print_id' => ['required', 'min:4', 'unique:users'],
        ]);

        $data = array();
        $data['voter_name'] = $request->voter_name;
        $data['age'] = $request->age;
        $data['nid'] = $request->nid;
        $data['user_name'] = $request->user_name;
        $data['finger_print_id'] = Hash::make($request->finger_print_id);

        DB::table('users')->insert($data);

        return $this->login($request);      //------------------------
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([           //---------------------------
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user_name'     => auth()->user()->user_name,             //--OR-- Auth::user()->name
            'user_id'      => auth()->user()->id,
            'finger_print_id' => auth()->user()->finger_print_id,         //-- Auth::user()->email
        ]);
    }
}
