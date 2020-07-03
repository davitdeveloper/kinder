<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ClientShopCardProduct;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($alias)
    {
        $model = ProductModel::where('alias',$alias)->first();
        if(!$model) return response()->json(['message' => 'Product not found'],404);
        return response()->json([
            'product' => $model->load(['products' => function($q){
                $q->with(['color' => function($q){
                    $q->where('name','!=','No color');
                },'size','images']);
            },'manufacturer']),
            'rates' => Rate::all()
        ],200);
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

    public function getCartProducts($userId){
        $user = User::find($userId);
        if($user){
           $products =  $user->shopProducts()->with(['model'=>function($q){
               $q->select(['id','title','short_description','manufacturer_id'])->with(['manufacturer'=>function($q){
                   $q->select('id','name');
               }])->get();
           },'images','color','size'])->withPivot('quantity')->get();
            return response()->json([
                'products' => $products,
                'rates' => Rate::all(),
            ],200);
        }
        return response()->json('Something went wrong',400);
    }

    public function addToCart(Request $request,$userId)
    {
        $user = User::find($userId);
        if(!$user) return response()->json(['message' => 'User not found'],404);

        $option = $user->shopProducts()->where('product_id',$request->id)->first();
        if($option){
            return response()->json(['message' => 'Այս ապրանքը արդեն ձեր զամբյուղում է։'],200);
        }
        $user->shopProducts()->attach(['product_id'=>$request->id],['quantity'=>$request->quantity]);
        return response()->json(['message' => 'Ապրանքը հաջողությամբ ավելացվել է զամբյուղ։'],200);
    }

    public function addManyToCart(Request $request,$userId)
    {
        $user = User::findOrFail($userId);
        $products = [];
        if($request->id){
            $product = $user->shopProducts()->where('product_id',$request->id)->withPivot('quantity')->first();
            if(!$product){
                $user->shopProducts()->attach(['product_id'=>$request->id],['quantity'=>$request->quantity]);
            }
            else{

                $quantity = $product->pivot->quantity + $request->quantity;
                ClientShopCardProduct::where([
                    ['product_id',$request->id],
                    ['user_id',$userId],
                ])->update(['quantity' => $quantity]);
            }
            foreach ($user->shopProducts()->withPivot('quantity')->get() as $key => $product){
                $products[$key]['id'] = $product->id;
                $products[$key]['quantity'] = $product->pivot->quantity*1;
            }
            return response()->json($products,200);
        }
        if(count($request->all()) && !$request->id){
            foreach ($request->all() as $prod){
                $product = $user->shopProducts()->where('product_id',$prod['id'])->withPivot('quantity')->first();
                if(!$product){
                    $user->shopProducts()->attach(['product_id'=>$prod['id']],['quantity'=>$prod['quantity']]);
                    continue;
                }
                else{
                    $quantity = $product->pivot->quantity + $prod['quantity'];
                    ClientShopCardProduct::where([
                        ['product_id',$prod['id']],
                        ['user_id',$userId],
                    ])->update(['quantity' => $quantity]);
                    continue;
                }
            }
            foreach ($user->shopProducts()->withPivot('quantity')->get() as $key => $product){
                $products[$key]['id'] = $product->id;
                $products[$key]['quantity'] = $product->pivot->quantity*1;
            }
            return response()->json($products,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }


    public function notLogedUserCardProducts(Request $request)
    {
        $favorites = Product::findOrFail($request->all())->load(['images','color','size','model'=>function($q){
            $q->with('manufacturer');
        }]);
        return response()->json($favorites,200);
    }


    public function deleteCartProduct($id,$userId){

        $result = User::find($userId) ? User::find($userId)->shopProducts()->detach($id) : null;
        if($result){
            return response()->json($id*1,200);
        }
        return response()->json('Something went wrong',400);
    }
}
