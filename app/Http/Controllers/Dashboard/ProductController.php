<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Color;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductModel;
use App\Models\Size;
use App\Models\User;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // if ($request->expectsJson()) {
        //     return 'yes';
        // }

        // return 'no';

        $products = Product::with(['model', 'distributors' => function($q){
            $q->with('distributor');
        }, 'color','size','images'])->latest()->get();
        if($products->count() === 0) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json($products,200);
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
    public function store(CreateProductRequest $request)
    {
        return $request->uploadImages()->createProducts();
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
    public function update(UpdateProductRequest $request, $id)
    {
        return $request->uploadImages()->updateProduct($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product){
            foreach ($product->images as $img) {
                $image = str_replace('/storage', '', $img->image);
                Storage::delete('/public' . $image);
            }
            if(Product::destroy($id)) return response()->json($id,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchModel(Request $request){
        $models = ProductModel::where('text', 'LIKE', "%$request->search%")->take(5)->get();
        if($models->count() === 0) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json($models->toArray(),200);
    }

    /**
     * @param $id
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getColors(){
        return response()->json(["colors" => Color::all()],200);
    }

    public function getSizes($modelId,$colorId){
        $model = ProductModel::find($modelId);
        $sizes = [];
        $data = [];

        if($model){

            $prods = $model->products()->where('color_id',$colorId)->get();

            if($prods){
                foreach ($prods as $pr){
                    $data[] = $pr->size->id;
                }
                if($model->type !== 'Other'){
                    $req = Manufacturer::find($model->manufacturer_id)->sizes('\App\Models\Manufacturer'.$model->type.'Size');

                    foreach ($data as $s){
                        $req = $req->where('size_id','<>',$s);
                    }
                    $sizes = $req->with('size')->get();
                }
            }
        }

        return response()->json(["sizes" => $sizes],200);
    }


    public function getDistributorProducts($id)
    {
        $user = User::findOrFail($id);
        $dist = $user->distributor;
        if(!$dist) return response()->json(['message' => 'Distributor not found'],404);
        return response()->json($user->products()->with([
            'color',
            'size',
            'model' => function($q){
                $q->select(['title','short_description','id']);
            }
        ])->select(['model_id','size_id','color_id'])->get(),200);
    }


    public function getProductForUpdate($man_id,$size_id,$type){
        $model = '\App\Models\Manufacturer'.$type.'Size';
        $size = $model::where('manufacturer_id',$man_id)->where('size_id',$size_id)->with('size')->first();
        if(!$size) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json($size,200);
    }

    public function delImg(Request $request)
    {
        $img = ProductImage::where('image',$request->image)->first();
        if(!$img) return response()->json(['message' => 'Something went wrong'],400);
        $productImage = str_replace('/storage', '', $img->image);
        Storage::delete('/public' . $productImage);
        if($img->delete()) return response()->json($request->image,200);
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
