<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Color;
use App\Models\Manufacturer;
use App\Models\OwnProduct;
use App\Models\OwnProductImage;
use App\Models\ProductCategory;
use App\Models\ProductModel;
use App\Models\Rate;
use App\Models\Size;
use App\Models\User;
use App\MyHelpers\SlugConverter;
use App\MyHelpers\UploadFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OwnProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $category = null, $subCategory = null, $subSubCategory = null)
    {
        $rates = Rate::all();
        $ids = [];
        $alias = null;
        $subAlias = null;
        $subsubAlias = null;

        $page = $request->page ? $request->page : 1;
        $perPage = $request->perpage ? $request->perpage : 15;
        $minPrice = $request->minPrice ? $request->minPrice : null;
        $maxPrice = $request->maxPrice ? $request->maxPrice : null;
        $search = $request->search ? $request->search : null;
        $condition = $request->condition ? $request->condition : null;
        $city = $request->city ? $request->city : null;
        $order = $request->order == 'desc' ? 'DESC' : 'ASC';


        if($category){
            $cat1 = ProductCategory::where('alias',$category)->first();
            $alias = $cat1 ;
            $ids[] = $cat1 ? $cat1->id : 999 ;
        }
        if($subCategory){
            $cat2 = ProductCategory::where('alias',$subCategory)->first();
            $subAlias = $cat2;
            $ids[] = $cat2 ? $cat2->id : 999 ;
        }
        if($subSubCategory){
            $cat3 = ProductCategory::where('alias',$subSubCategory)->first();
            $subsubAlias = $cat3;
            $ids[] = $cat3 ? $cat3->id : 999 ;
        }

        if ($search){
            $req = OwnProduct::search($search);
        }
        else if(!$category){
            $req = new OwnProduct;
        }
        else{
            $req = OwnProduct::whereJsonContains('category_ids',$ids);
        }

        $req = $req->where('status',1)
            ->with(['owner','city','images']);
        if ($minPrice) $req = $req->where('price','>=', $minPrice);
        if ($maxPrice) $req = $req->where('price','<=', $maxPrice);
        if ($condition) $req = $req->where('condition', $condition);
        if ($city) $req = $req->where('city_id', $city);

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
        return response()->json([
            'rates' => $rates,
            'products' => $products,
            'cities' => Cities::all(),
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'search' => $search,
            'city' => $city,
            'condition' => $condition,
            'alias' => $alias,
            'subAlias' => $subAlias,
            'subsubAlias' => $subsubAlias,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'product.title' => 'required|max:255|min:2',
            'product.description' => 'required|min:30',
            'category_ids' => 'required|array',
            'product.price' => 'required|integer',
            'product.phone' => 'required',
            'product.condition' => 'required',
            'product.city_id' => 'required|integer',
            'images.*' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $data = [];
        $alias = SlugConverter::slug($request->product['title']).'_'.Str::uuid()->toString();
        foreach ($request->category_ids as $cat){
            $categories[] = $cat*1;
        }
        $manufacturer = $request->product['manufacturer'];
        if($request->product['my_manufacturer']){
            $manufacturer = $request->product['my_manufacturer'];
        }
        $data['user_id'] = $request->product['user_id'];
        $data['title'] = $request->product['title'];
        $data['description'] = $request->product['description'];
        $data['manufacturer'] = $manufacturer;
        $data['color'] = $request->product['color'];
        $data['category_ids'] = $categories;
        $data['price'] = $request->product['price'];
        $data['phone'] = $request->product['phone'];
        $data['condition'] = $request->product['condition'];
        $data['city_id'] = $request->product['city_id'];
        $data['alias'] = $alias;
        if(!User::find($request->product['user_id'])) return response()->json(['message' => 'User not unauthorized'],401);

        DB::beginTransaction();

        $product = OwnProduct::create($data);

        if($product){
            $images = $request->images;
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'own-product'.DIRECTORY_SEPARATOR);
            foreach ($images as $item){
                $imgName = UploadFile::upload($item,$path);
                if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                $image = "/storage/own-product/".$imgName;
                $pimg = OwnProductImage::create([
                    'own_product_id' => $product->id,
                    'image' => $image
                ]);
                if(!$pimg){
                    DB::rollBack();
                    return response()->json(['message' => 'Something went wrong'],400);
                }
            }
            DB::commit();
            return response()->json($product->load('images'),200);
        }
        DB::rollBack();
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($alias)
    {
        $product = OwnProduct::where('alias',$alias)->first();
        if(!$product) return response()->json(['message' => 'Product not found'],404);
        return response()->json([
            'product' => $product->load(['images','city','owner']),
            'rates' => $rates = Rate::all()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = OwnProduct::find($id);
        if(!$product) return response()->json(['message' => 'Product not found'],404);
        $imgRequired = '';
        $imgValidated = '';
        if(!$product->images()->first()){
            $imgRequired = 'required|array';
            $imgValidated = 'required|image|mimes:jpeg,jpg,png';
        }
        $request->validate([
            'product.title' => 'required|max:255|min:2',
            'product.description' => 'required|min:30',
            'category_ids' => 'required|array',
            'product.price' => 'required|integer',
            'product.phone' => 'required',
            'product.condition' => 'required',
            'product.city_id' => 'required|integer',
            'images' => $imgRequired,
            'images.*' => $imgValidated,
        ]);

        $data = [];
        $alias = SlugConverter::slug($request->product['title']).'_'.Str::uuid()->toString();
        foreach ($request->category_ids as $cat){
            $categories[] = $cat*1;
        }
        $manufacturer = $request->product['manufacturer'];
        if($request->product['my_manufacturer']){
            $manufacturer = $request->product['my_manufacturer'];
        }
        $data['user_id'] = $request->product['user_id'];
        $data['title'] = $request->product['title'];
        $data['description'] = $request->product['description'];
        $data['manufacturer'] = $manufacturer;
        $data['color'] = $request->product['color'];
        $data['category_ids'] = $categories;
        $data['price'] = $request->product['price'];
        $data['phone'] = $request->product['phone'];
        $data['condition'] = $request->product['condition'];
        $data['city_id'] = $request->product['city_id'];
        $data['alias'] = $alias;
        if(!User::find($request->product['user_id'])) return response()->json(['message' => 'User unauthorized'],401);

        DB::beginTransaction();

        $prod =$product->update($data);

        if($prod){
            $images = $request->images;
            if($images){
                $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'own-product'.DIRECTORY_SEPARATOR);
                foreach ($images as $item){
                    $imgName = UploadFile::upload($item,$path);
                    if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                    $image = "/storage/own-product/".$imgName;
                    $pimg = OwnProductImage::create([
                        'own_product_id' => $product->id,
                        'image' => $image
                    ]);
                    if(!$pimg){
                        DB::rollBack();
                        return response()->json(['message' => 'Something went wrong'],400);
                    }
                }
            }
            DB::commit();
            return response()->json($product->fresh(),200);
        }
        DB::rollBack();
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
        $product = OwnProduct::find($id);
        if ($product){
            foreach ($product->images as $img) {
                $image = str_replace('/storage', '', $img->image);
                Storage::delete('/public' . $image);
            }
            if(OwnProduct::destroy($id)) return response()->json($product,200);
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json(['message' => 'Product not found'],404);
    }


    public function getInfo()
    {
        return response()->json([
            'cities' => Cities::all(),
            'colors' => Color::all(),
            'manufacturers' => Manufacturer::all()
        ],200);
    }

    public function getMyProducts($id)
    {
        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'User not found'],404);
        return response()->json([
            'products' => $user->myProducts()->latest()->with('images')->get(),
            'rates' => Rate::all()
        ],200);
    }

    public function delImg($id)
    {
        $img = OwnProductImage::find($id);
        if(!$img) return response()->json(['message' => 'Image not found'],404);
        $productImage = str_replace('/storage', '', $img->image);
        Storage::delete('/public' . $productImage);
        if($img->delete()) return response()->json(['message' => 'Product Image deleted successful'],200);
        return response()->json(['message' => 'Something went wrong'],400);
    }

    public function upProductInList($id,$userId)
    {
        $product = OwnProduct::find($id);
        if(!$product) return response()->json(['message' => 'Product not found'],404);
        $result = $product->update(['created_at' => Carbon::now()]);
        if(!$result)  return response()->json(['message' => 'Something went wrong'],400);
        $user = User::find($userId);
        if(!$user) return response()->json(['message' => 'User not found'],404);
        return response()->json([
            'products' => $user->myProducts()->latest()->with('images')->get(),
            'rates' => Rate::all()
        ],200);
    }
}
