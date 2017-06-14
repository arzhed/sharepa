<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Adventure;

class AdventureController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $user = \Auth::user();

        $this->validate($request, [
            'title'             => 'string|required',
            'price'             => 'int|required|min:1',
            'short_description' => 'string|required',
            'long_description'  => 'string|required',
            'files'             => 'array'
        ]);

        $adventure = new Adventure;
        $adventure->title            = $request->title;
        $adventure->price            = $request->price;
        $adventure->description      = $request->short_description;
        $adventure->long_description = $request->long_description;

        $user->adventures()->save($adventure);

        foreach ($request->get('files') as $key => $value) {
            $adventure->photos()->attach($value);
        }
        // $adventure->photos;

        return $adventure;
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
