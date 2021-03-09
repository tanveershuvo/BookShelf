<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JwtMiddleware', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['err' => 'Credential Mismatched'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }


    public function register(Request $request)
    {
        $user = User::create([
           'email'=>$request->email,
           'name'=>$request->name,
           'password'=> Hash::make($request->password)
           ]);
        if($user){
            return response()->json(['status'=>false,'data'=>'User Cretaed Succesfully']);
        } else {
            return response()->json(['status'=>false,'data'=>null]);
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

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

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 1,
            'user_name'=>auth('api')->user()->name,
            'user_type'=>auth('api')->user()->usertype,
        ]);
    }
}
