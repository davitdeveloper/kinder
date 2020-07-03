<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Discount\ModelDiscount;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ModelDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(ModelDiscount::with('model')->get(),200);
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
            'model_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'percent' => 'required|integer',
        ]);
        $model = ProductModel::find($request->model_id);
        if($model){
            $discount = ModelDiscount::create($request->only(['model_id','start','end','percent']));
            $price = $model->price - ($model->price*$discount->percent/100);
            $data['old_price'] = $model->price;
            $data['price'] = $price;
            $model->update($data);
            return response()->json($discount->load('model'),200);
        }
        return response()->json(['message' => 'Model not found'],404);
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
            'model_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'percent' => 'required|integer',
        ]);
        $discount = ModelDiscount::find($id);
        if(!$discount) return response()->json(['message' => 'Discount not found'],404);
        $model = ProductModel::find($request->model_id);
        if($model){
            $discount->update($request->only(['model_id','start','end','percent']));
            $discount = $discount->fresh();
            $price = $model->price - ($model->price*$discount->percent/100);
            $data['old_price'] = $model->price;
            $data['price'] = $price;
            $model->update($data);
            return response()->json($discount->load('model'),200);
        }
        return response()->json(['message' => 'Model not found'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $discount = ModelDiscount::find($id);
        if($discount){
            if($discount->delete()) return response()->json($discount,200);
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json(['message' => 'Discount not found'],404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchModel(Request $request){
        $models = ProductModel::whereDoesntHave('discount')->where('text', 'LIKE', "%$request->search%")->take(5)->get()->toArray();
        return response()->json($models,200);
    }
}
