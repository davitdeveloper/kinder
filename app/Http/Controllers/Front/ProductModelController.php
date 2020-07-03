<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Manufacturer;
use App\Models\ProductCategory;
use App\Models\ProductModel;
use App\Models\Rate;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;

class ProductModelController extends Controller
{
    /**
     * @param Request $request
     * @param null $category
     * @param null $subCategory
     * @param null $subSubCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $category = null, $subCategory = null, $subSubCategory = null)
    {
        if($subSubCategory == 'undefined' || $subCategory == 'undefined' || $category == 'undefined'){
            return response()->json(['message' => 'Something went wrong'],400);
        }
        $manufacturers = Manufacturer::all();
        $data=[];
        $sizes = [];
        $ids = null;
        $alias = null;
        $subAlias = null;
        $subsubAlias = null;
        $sizeType = '';

        $page = $request->page ? $request->page : 1;
        $perPage = $request->perpage ? $request->perpage : 15;
        $minPrice = $request->min_price ? $request->min_price : null;
        $maxPrice = $request->max_price ? $request->max_price : null;
        $color = $request->color ? $request->color : null;
        $size = $request->size ? $request->size : null;
        $search = $request->search ? $request->search : null;
        $manufacturer = $request->manufacturer ? $request->manufacturer : null;
        $order = $request->order == 'desc' ? 'DESC' : 'ASC';


        if($category){
            $cat1 = ProductCategory::where('alias',$category)->first();
            $sizeType = $cat1->size_type;
            $alias = $cat1 ;
            $ids[] = $cat1 ? $cat1->id : 999 ;
        }
        if($subCategory){
            $cat2 = ProductCategory::where('alias',$subCategory)->first();
            $sizeType = $cat2->size_type;
            $subAlias = $cat2;
            $ids[] = $cat2 ? $cat2->id : 999 ;
        }
        if($subSubCategory){
            $cat3 = ProductCategory::where('alias',$subSubCategory)->first();
            $sizeType = $cat3->size_type;
            $subsubAlias = $cat3;
            $ids[] = $cat3 ? $cat3->id : 999 ;
        }

        if($sizeType == Size::TOP) $sizes = Size::where('type',Size::TOP)->get();
        if($sizeType == Size::SHOE) $sizes = Size::where('type',Size::SHOE)->get();
        if($sizeType == Size::ACCESSORY) $sizes = Size::where('type',Size::ACCESSORY)->get();
        if($sizeType == Size::PANT) $sizes = Size::where('type',Size::PANT)->get();

        if ($search){
            $req = ProductModel::where('text', 'LIKE', "%$search%");
        }
        else{
            $req = ProductModel::whereJsonContains('category_ids',$ids);
        }


        $models = $req->where('status',1)
            ->whereHas('products')->with(['products'=>function($q){
                $q->with('color');
            }])->get();

        foreach($models as $model){
            foreach($model->products as $product){
                if($product->color->value){
                    $data[] = $product->color->id;
                }
            }
        }
        $colors = Color::find($data);


        if($manufacturer) $req = $req->where('manufacturer_id',$manufacturer);

        $req = $req->where('status',1)
        ->whereHas('products',function($q) use($color,$size)
        {
            if ($color == null){
                $q = $q->whereHas('color');
            }
            else{
                $q = $q->whereHas('color',function($q)use($color){
                    $q->where('name','=', $color);
                });
            }

            if ($size){
                $q->whereHas('size',function($q)use($size){
                    $q->where('size_id','=', $size);
                });
            }
        })->with('products');

        if ($minPrice) $req = $req->where('price','>=', $minPrice);
        if ($maxPrice) $req = $req->where('price','<=', $maxPrice);

        if(!$req->get()->toArray()){
            $minPrice = ProductModel::min('price');
            $maxPrice = ProductModel::max('price');
        }
        else{
            $maxPrice = $req->max('price');
            $minPrice = $req->min('price');
        }

        if(count($req->get()) < 16){
            $page = 1;
        }
        $products = $req->orderByPrice($order)->paginate($perPage,'','',$page);
        if(!$products) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json([
            'products' => $products,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'sizes' => $sizes,
            'colors' => $colors,
            'manufacturers' => $manufacturers,
            'alias' => $alias,
            'subAlias' => $subAlias,
            'subsubAlias' => $subsubAlias,
            'rates' => Rate::all(),
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

    public function getFavoriteProducts($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json([
            'products' => $user->favoriteProducts()->with('manufacturer')->get(),
            'rates' => Rate::all()
        ],200);
    }

    public function notLogedUserFavorites(Request $request)
    {
       $favorites = ProductModel::findOrFail($request->all())->load('manufacturer');
        return response()->json($favorites,200);
    }

    public function createFavoriteProducts(Request $request,$userId)
    {
//        if(!$request->ids[0]) return response()->json(['message' => 'Something went wrong'],400);
        $ids = [];
        if($request->id){
            if(!User::find($userId)->favoriteProducts()->find($request->id)){
                User::find($userId)->favoriteProducts()->attach($request->id);
            }
            return response()->json($request->id,200);
        }
        $result = User::find($userId) ? User::find($userId)->favoriteProducts()->sync($request->all()) : null;
        if($result){
            foreach (User::find($userId)->favoriteProducts as $model){
                $ids[] = $model->id;
            }
            return response()->json($ids,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }


//    public function addRemoveFavorite(Request $request,$userId)
//    {
//        $user = User::findOrFail($userId);
//        $favorite = $user->favoriteProducts()->where('model_id',$request->model_id)->first();
//        if($favorite){
//            $user->favoriteProducts()->detach($request->model_id);
//            return response()->json(['id'=>$request->model_id],200);
//        }
//        $user->favoriteProducts()->attach($request->model_id);
//        return response()->json(['id'=>$request->model_id],200);
//    }

    public function deleteFavoriteProduct($productId,$userId){
        $result = User::find($userId) ? User::find($userId)->favoriteProducts()->detach($productId) : null;
        if($result){
            return response()->json($productId,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }



    public function getFilterItems($type)
    {
        $colors = Color::all();
    }
}
