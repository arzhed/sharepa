<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Adventure;

use Validator;

class AdventureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();
        if ($request->exists('guide') && \Auth::check()) {
            $user->adventures->each(function(&$a) {
                $a->cover;
            });
            return $user->adventures;
        }
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
            'description'       => 'string|required',
            'long_description'  => 'string|required',
            'files'             => 'array',
            'cover_photo'       => 'integer|exists:files,id'
        ]);

        $adventure = new Adventure;
        $adventure->title            = $request->title;
        $adventure->price            = $request->price;
        $adventure->description      = $request->description;
        $adventure->long_description = $request->long_description;
        $adventure->cover_photo      = $request->cover_photo;

        $user->adventures()->save($adventure);

        foreach ($request->get('files') as $key => $value) {
            $adventure->files()->attach($value['id']);
        }
        die;

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
        $valid = Validator::make([
            'id' => $id
        ], [
            'id' => 'required|exists:adventures'
        ]);

        if ($valid->fails()) {
            return response('Adventure does not exist', 404);
        }

        return Adventure::find($id)->load('files');
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
        $params       = $request->all();
        $params['id'] = $id;

        $valid = Validator::make($params, [
            'id'                => 'required|exists:adventures',
            'title'             => 'string',
            'price'             => 'int|min:1',
            'description'       => 'string',
            'long_description'  => 'string',
            'files'             => 'array',
            'cover_photo'       => 'integer|exists:files,id'
        ]);

        if ($valid->fails()) {
            return response('Something went wrong', 400);
        }

        unset($params['id']);

        $files = $params['files'];
        unset($params['files']);

        $adventure = Adventure::find($id);
        $adventure->update($params);

        return $adventure;
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
