<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GlobalSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Size::all()->sortBy('sortable')->values()->all(),200);
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
            'value' => 'required',
            'type' => ['required',Rule::in(['Top','Shoe','Accessory','Pant'])],
            'rang' => 'required',
        ]);
        $size = Size::where([['type',$request->type],['value',$request->value]])->first();
        if($size)  return response()->json(['message' => 'This size for type '.$request->type.' is exists in table'],422);
        $rang = $request->type.$request->rang;
        return response()->json(Size::create([
            'value' => $request->value,
            'type' => $request->type,
            'rang' => $request->rang,
            'sortable' => $rang,
        ]),200);
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
            'value' => 'required',
            'type' => ['required',Rule::in(['Top','Shoe','Accessory','Pant'])],
            'rang' => 'required',
        ]);
        if(!Size::find($id)) return response()->json(['message' => 'This size not found'],404);
        $size = Size::where([['type',$request->type],['value',$request->value],['id','!==',$id]])->first();
        if($size)  return response()->json(['message' => 'This size for type '.$request->type.' is exists in table'],422);
        $rang = $request->type.$request->rang;
        return response()->json(Size::find($id)->update([
            'value' => $request->value,
            'type' => $request->type,
            'rang' => $request->rang,
            'sortable' => $rang,
        ]),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return response()->json($size,200);
    }
}
