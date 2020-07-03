<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Color::all());
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors,name',
            'value' => 'required|min:7',
            'tint' => 'required',
        ]);
        $color = Color::create($request->only(['name','value','tint']));
        if($color){
            return response()->json($color,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:colors,name,'.$id,
            'value' => 'required|min:7',
            'tint' => 'required',
        ]);
        $color = Color::find($id);
        if(!$color){
            return response()->json(['message' => 'Color not found!'],404);
        }
        $result = $color->update($request->only(['name','value','tint']));
        if($result){
            return response()->json($color->fresh(),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $color = Color::find($id);
        if(!$color){
            return response()->json(['message' => 'Color not found!'],404);
        }
        if($color->delete()) return response()->json('Color deleted successful',200);
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
