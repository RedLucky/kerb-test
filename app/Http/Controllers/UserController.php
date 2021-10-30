<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::simplePaginate(env("PAGINATE_PAGE",10));
        return $this->responseJson(200,"success", $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:App\Models\User,name',
            'username' => 'required|unique:App\Models\User,username',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required',
            'role' => [
                'required',
                Rule::in(['ppic', 'finance']),
            ],
        ]);

        if ($validate->fails()) {
            return $this->responseJson(400,$validate->errors(),[]);
        }
        $requestPayload = request()->all();
        $requestPayload['status'] = 'A';
        $requestPayload['password'] = bcrypt($request->password);
        $user = User::create($requestPayload);
        if(!$user){
            return $this->responseJson(500,"internal server error, insert user fail");
        }

        return $this->responseJson(200,"success", $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return $this->responseJson(404,"user not found");
        }
        return $this->responseJson(200,"success", $user);
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
        $validate = Validator::make($request->all(), [
            'role' => [
                Rule::in(['ppic', 'finance']),
            ],
        ]);

        if ($validate->fails()) {
            return $this->responseJson(400,$validate->errors(),[]);
        }
        $user = User::find($id);
        if(!$user){
            return $this->responseJson(404,"user not found");
        }
        $requestPayload = $request->all();
        if($request->has('password')){
            $requestPayload['password'] = bcrypt($request->password);
        }
        if (!$user->update($requestPayload)){
            return $this->responseJson(404,"internal server error, update user fail");
        }
        return $this->responseJson(200,"success update", $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return $this->responseJson(404,"User not found");
        }
        $user->delete();
        return $this->responseJson(200,"delete success");
    }
}
