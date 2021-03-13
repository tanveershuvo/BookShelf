<?php

namespace App\Http\Controllers;


use App\Http\Requests\AuthorStoreRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('JwtMiddleware', ['except' => ['login','register']]);
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response(['msg' => 'Credential Mismatched','type'=>'red'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param AuthorStoreRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function register(AuthorStoreRequest $request)
    {
        try{
            User::create([
               'email'=>$request->email,
               'name'=>$request->name,
               'password'=> Hash::make($request->password)
            ]);
            return response(['msg' => 'User Created Successfully! Please Login Now!','type'=>'success'], Response::HTTP_OK);
        }catch (\Exception $e) {
            return response(['msg' => $e->getMessage(),'type' => 'red'],$e->getCode());
        }
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function logout()
    {
        auth('api')->logout();

        return response();
    }


    /**
     * @return Application|ResponseFactory|Response
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * @param string $token
     * @return Application|ResponseFactory|Response
     */
    protected function respondWithToken(string $token)
    {
        return response([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 1,
            'user_name'=>auth('api')->user()->name,
            'user_type'=>auth('api')->user()->usertype,
        ]);
    }
}
