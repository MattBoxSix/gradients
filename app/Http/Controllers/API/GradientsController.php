<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Request as HttpRequest;

use App\Gradients;

use Illuminate\Support\Facades\Input;

class GradientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort = HttpRequest::get('sort');
        if ($sort == null) {
            $sortBy = 'created_at';
        } elseif ($sort == 'name') {
            $sortBy = 'name';
        } elseif ($sort == 'color1') {
            $sortBy = 'color1';
        } elseif ($sort == 'color2') {
            $sortBy = 'color2';
        } else {
            $sortBy = 'created_at';
        }
        $gradients = Gradients::orderBy($sortBy)->paginate(8);
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
        $gradient->name = $request->input('name');
        $gradient->color1 = $request->input('color1');
        $gradient->color2 = $request->input('color2');
        $gradient->save();
        $pages = floor((Gradients::all()->count() + 7 ) / 8);          
        return response()->json([
            'gradient' => $gradient,
            'lastPage' => $pages
        ], 200);
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
        return response()->json([
            'status' => 'Gradient Deleted'
        ]);
    }
}
