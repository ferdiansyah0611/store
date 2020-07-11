<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use File;
// vendor
use Carbon\Carbon;
// models
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::latest()->paginate(25), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|min:8|max:20',
            'gender' => 'required|string|min:3|max:6',
            'born' => 'required|date',
            'location' => 'required|string|min:4|max:191',
            'role' => 'required|string',
            'status' => 'required|string|min:5|max:9',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            if($request->file('file')) {
                $validator_avatar = Validator::make($request->all() [
                    'file' => 'required|max:2000'
                ]);
                // abort
                if($validator_avatar->fails()) {
                    return response()->json(['message' => $validator->errors()], 401);
                } else {
                    $file = $request->file('file');
                    $name = $file->getClientOriginalName();
                    if($name !== 'avatar-admin.png' || $name !== 'avatar-user-male.png' || $name !== 'avatar-user-female.png') {
                        $file->move(storage_path('app/public/image', $name));
                        $data['avatar'] = $name;
                    }
                }
            } else {
                $role = $request->role;
                $gender = $request->gender;
                if($role == 'administrator' || $role == 'admin') {
                    $data['avatar'] = 'avatar-admin.png';
                }
                if($role == 'user') {
                    if($gender == 'male') {
                        $data['avatar'] = 'avatar-user-male.png';
                    }
                    if($gender == 'female') {
                        $data['avatar'] = 'avatar-user-female.png';
                    }
                }
            }
            User::create($data);
            return response()->json(['message' => 'Successfuly create data'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return response()->json(User::where('id', $user)->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|min:8|max:20',
            'gender' => 'required|string|min:3|max:6',
            'born' => 'required|date',
            'location' => 'required|string|min:4|max:191',
            'role' => 'required|string',
            'status' => 'required|string|min:5|max:9',
        ]);
        // abort
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 401);
        } else {
            $data = $request->all();
            if($request->file('file')) {
                $validator_avatar = Validator::make($request->all() [
                    'file' => 'required|max:2000'
                ]);
                // abort
                if($validator_avatar->fails()) {
                    return response()->json(['message' => $validator->errors()], 401);
                } else {
                    $file = $request->file('file');
                    $name = $file->getClientOriginalName();
                    $user = User::where('id', $user)->pluck('avatar');
                    if($name !== 'avatar-admin.png' || $name !== 'avatar-user-male.png' || $name !== 'avatar-user-female.png') {
                        File::delete(storage_path('app/public/image/' . $user[0]));
                        $file->move(storage_path('app/public/image', $name));
                        $data['avatar'] = $name;
                    }
                    if($user[0] == $name) {
                        $data['avatar'] = $name;
                    }
                }
            }
            User::where('id', $user)->update($data);
            return response()->json(['message' => 'Successfuly update data'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        User::where('id', $user)->update($data);
        return response()->json(['message' => 'Successfuly delete data'], 200);
    }
}
