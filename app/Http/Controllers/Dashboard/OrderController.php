<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\CompleteOrderMailToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::latest()->with(['user','products' =>function($q){
            $q->with(['product' => function($q){
                $q->with(['color','size','model' => function($q){
                    $q->with('manufacturer');
                }]);
            }]);
        }])->get();
        if($orders->count() == 0) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json($orders,200);
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

    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        if($order->status == 0){
            $result = Order::find($id)->update(['status' => '1']);
            $toUser = User::findOrFail($order->user_id);
            Notification::send($toUser, new CompleteOrderMailToUser());
        }
        if($order->status == 1){
            $result = Order::find($id)->update(['status' => '0']);
        }
        if($result){
            return response()->json($order->fresh()->load(['user','products' =>function($q){
                $q->with(['product' => function($q){
                    $q->with(['color','size','model' => function($q){
                        $q->with('manufacturer');
                    }]);
                }]);
            }]),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
