<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $keyword = $request->keyword;
        $status = $request->status;

        if ($keyword) {
            if ($status) {
                $users = User::where('id', '!=', Auth::id())->where('email', 'like', "%$keyword%")->where("status", $status)->paginate(10);
            } else {
                $users = User::where('id', '!=', Auth::id())->where('email', 'like', "%$keyword%")->paginate(10);
            }
        } else if ($status) {
            $users = User::where('id', '!=', Auth::id())->where('status', $status)->paginate(10);
        } else {
            $users = User::where('id', '!=', Auth::id())->paginate(10);
        }


        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "username" => "required|min:5|max:20",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
            "avatar" => "required",
            "email" => "required|email",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ])->validate();

        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->username = $request->username;
        $new_user->phone = $request->phone;
        $new_user->email = $request->email;
        $new_user->address = $request->address;
        $new_user->password = Hash::make($request->password);
        $new_user->roles = json_encode($request->roles);

        if ($request->avatar) {
            $file = $request->avatar->store("avatars", 'public');
            $new_user->avatar = $file;
        }
        $new_user->save();
        return redirect()->route('users.create')->with("status", "User Has Been Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view("users.detail", ["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view("users.edit", ["user" => $user]);
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

        Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
        ])->validate();
    
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->roles = json_encode($request->roles);

        if ($request->avatar) {
            $file = $request->avatar->store("avatars", 'public');
            $user->avatar = $file;
        }
        $user->save();
        return redirect()->route('users.edit', [$id])->with('status', 'User succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User successfully delete');
    }
}
