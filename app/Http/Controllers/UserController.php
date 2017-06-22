<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|string|in:traveler,guide',
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        User::find($id);

        return $user;
    }

    /**
     * getByMail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getByMail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        return $user;
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
        $user = \Auth::user();

        if ($user->id != $id) {
            return response('You are not this user', 403);
        }

        $this->validate($request, [
            'short_bio' => 'string|max:300',
            'long_bio'  => 'string',
            'role'      => 'in:guide,traveler'
        ]);

        $user->update($request->all());

        return $user->toArray();
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
