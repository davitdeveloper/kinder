<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClientShopCardProduct;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderMailToAdmin;
use App\Notifications\OrderMailToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            "user_id" => "required",
            "phone" => "required",
            "address" => "required",
            "price" => "required",
            "products" => "array",
            "products.*.product_id" => "required",
            "products.*.quantity" => "required",
            "products.*.single_price" => "required",
        ]);
        $user = User::findOrFail($request->user_id);
        DB::beginTransaction();
        $order = Order::create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'price' => $request->price,
        ]);

        if (!$order) return response()->json(['message' => 'Something went wrong']);
        foreach ($request->products as $product){
            $orderProduct = $order->products()->create([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['quantity'] * $product['single_price']
            ]);

            $deletedShopCardProduct = ClientShopCardProduct::where('user_id',$user->id)->where('product_id',$product['product_id'])->delete();
            if(!$orderProduct || !$deletedShopCardProduct){
                DB::rollBack();
                return response()->json(['message' => 'Something went wrong']);
            }
        }
        $shopCard = $user->shopProducts;
        if($shopCard->count() !== 0){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong']);
        }
        DB::commit();
        Notification::send($user, new OrderMailToUser());

        $toUser = User::findOrFail(1);
        Notification::send($toUser, new OrderMailToAdmin($user));

        return response()->json('Order created successful',200);
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
