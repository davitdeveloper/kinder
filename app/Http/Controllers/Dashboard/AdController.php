<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OwnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(OwnProduct::latest()->with(['images','owner','city','categories'])->get(),200);
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
        //
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
        $ad = OwnProduct::find($id);
        if(!$ad) return response()->json(['message' => 'Ad not found'],404);;
        $ad->update($request->only('status'));

        return response()->json($ad->fresh()->load(['images','owner','city','categories']),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = OwnProduct::find($id);
        if ($product){
            foreach ($product->images as $img) {
                $image = str_replace('/storage', '', $img->image);
                Storage::delete('/public' . $image);
            }
            if(OwnProduct::destroy($id)) return response()->json($id,200);
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json(['message' => 'Ad not found'],404);
    }
}
