<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Discount\ProductDiscount;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(ProductDiscount::with(['product' => function($q){
            $q->with(['model','color','size']);
        }])->get(),200);
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
            'product_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'percent' => 'required|integer',
        ]);
        $product = Product::find($request->product_id);
        if($product){
            $discount = ProductDiscount::create($request->only(['product_id','start','end','percent']));
            $price = $product->price - ($product->price*$discount->percent/100);
            $data['old_price'] = $product->price;
            $data['price'] = $price;
            $product->update($data);
            return response()->json($discount->load(['product' => function($q){
                $q->with(['model','color','size']);
            }]),200);
        }
        return response()->json(['message' => 'Product not found'],404);
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
            'product_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'percent' => 'required|integer',
        ]);
        $discount = ProductDiscount::find($id);
        if(!$discount) return response()->json(['message' => 'Discount not found'],404);
        $product = Product::find($request->product_id);
        if($product){
            $discount->update($request->only(['product_id','start','end','percent']));
            $discount = $discount->fresh();
            $price = $product->price - ($product->price*$discount->percent/100);
            $data['old_price'] = $product->price;
            $data['price'] = $price;
            $product->update($data);
            return response()->json($discount->load(['product' => function($q){
                $q->with(['model','color','size']);
            }]),200);
        }
        return response()->json(['message' => 'Product not found'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $discount = ProductDiscount::find($id);
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
    public function searchProduct(Request $request){
        $models = Product::whereDoesntHave('discount')->where('text', 'LIKE', "%$request->search%")->take(5)->get()->toArray();
        return response()->json($models,200);
    }
}
