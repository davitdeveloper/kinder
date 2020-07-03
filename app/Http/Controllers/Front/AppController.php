<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Rate;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $babyProducts = ProductCategory::find(ProductCategory::BABY)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->limit(10)
            ->with('products','categories')
            ->get()->toArray();
        $toddlerProducts = ProductCategory::find(ProductCategory::TODDLER)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->limit(10)
            ->with('products','categories')
            ->get()->toArray();
        $foodProducts = ProductCategory::find(ProductCategory::BABY_FOOD)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->limit(10)
            ->with('products','categories')
            ->get()->toArray();
        $careProducts = ProductCategory::find(ProductCategory::BABY_CARE)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->limit(10)
            ->with('products','categories')
            ->get()->toArray();
        $accessoriesProducts = ProductCategory::find(ProductCategory::ACCESSORIES)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->limit(10)
            ->with('products','categories')
            ->get()->toArray();
        $rates = Rate::all();
        return response()->json([
            'babyProducts'=> $babyProducts,
            'toddlerProducts'=> $toddlerProducts,
            'foodProducts'=> $foodProducts,
            'careProducts'=> $careProducts,
            'accessoriesProducts'=> $accessoriesProducts,
            'rates'=> $rates,
        ],200);
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
