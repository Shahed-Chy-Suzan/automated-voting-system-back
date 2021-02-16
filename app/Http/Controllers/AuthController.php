<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required', 'min:4', 'string', 'max:255'],
            'password' => ['required', 'min:4'],
        ]);

        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'User or Finger Print field is Invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    public function signup(Request $request)    //---------------------------
    {
        $validateData = $request->validate([
            'username' => ['required', 'min:4', 'string', 'max:255'],
            'password' => ['required', 'min:4', 'unique:users'],
        ]);

        $data = array();
        $data['username'] = $request->username;
        $data['password'] = Hash::make($request->password);

        DB::table('users')->insert($data);

        return $this->login($request);      //------------------------
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([           //---------------------------
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'username'     => auth()->user()->username,             //--OR-- Auth::user()->name
            'user_id'      => auth()->user()->id,
            'password' => auth()->user()->password,         //-- Auth::user()->email
        ]);
    }
}
