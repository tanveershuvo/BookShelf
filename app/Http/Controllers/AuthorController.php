<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function index()
    {
        $authors = User::where('usertype',2)->get();
        return response($authors);
    }


    public function create(Request $request)
    {
    }


    public function store(Request $request)
    {
        User::create([
            'name'=>$request->data['name'],
            'email'=>$request->data['email'],
            'password'=>bcrypt('123456'),
            'usertype'=>2,
        ]);
        return response(['msg'=>'Authors Added','type'=>'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
