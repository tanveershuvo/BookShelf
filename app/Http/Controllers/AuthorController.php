<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        try{
            $authors = User::where('usertype',2)->get();
            return response($authors);
        }catch (Exception $e) {
            return response(['msg' => $e->getMessage(),'type' => 'red']);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        try{
            User::create([
                'name'=>$request->data['name'],
                'email'=>$request->data['email'],
                'password'=>bcrypt('123456'),
                'usertype'=>2,
            ]);
            return response(['msg'=>'Authors Added','type'=>'success']);
        }catch (Exception $e) {
            return response(['msg' => $e->getMessage(),'type' => 'red']);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function update(Request $request, $id)
    {
        try{
            User::find($id)->update([
                'name'=>$request->data['name'],
                'email'=>$request->data['email'],
                'password'=>bcrypt('123456'),
                'usertype'=>2,
            ]);
            return response(['msg'=>'Authors Edited','type'=>'info']);
        }catch (Exception $e) {
            return response(['msg' => $e->getMessage(),'type' => 'red']);
        }
    }

    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response(['msg'=>'Authors Deleted','type'=>'red']);
        }catch (Exception $e) {
            return response(['msg' => $e->getMessage(),'type' => 'red']);
        }
    }
}
