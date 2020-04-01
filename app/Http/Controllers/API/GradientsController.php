<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Gradients;

class GradientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradients = Gradients::all();
        return response()->json([
            'gradients' => $gradients,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gradient = new Gradients();
        $gradient->name = $request->name;
        $gradient->color1 = $request->color1;
        $gradient->color2 = $request->color2;
        $gradient->save();
        return $gradient;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gradientSearch = Gradients::findOrFail($id);
        $gradient = array();             
        $gradient['name'] = $request->name;
        $gradient['color1'] = $request->color1;
        $gradient['color2'] = $request->color2;
        if ($gradientSearch->update($gradient)) {
            return $gradient;
        }
        return response()->json([
            'status' => 'Error'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gradients::destroy($id);
        return response()->json('Image Deleted');
    }
}
