<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\ProductCategory;
use App\Models\ProductModel;
use App\Models\User;
use App\MyHelpers\SlugConverter;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(ProductModel::latest()->get());
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
            'title' => 'required|max:255|min:2',
            'sub_title' => 'required|max:255|min:2',
            'short_description' => 'required|min:2',
            'type' => 'required',
            'gender' => 'required',
            'long_description' => 'required|min:2',
            'manufacturer_id' => 'required',
            'category_ids' => 'required|array',
            'main_image' => 'required|image|mimes:jpeg,jpg,png',
            'price' => 'required|integer',
            'offerable' => 'required|integer',
            'top_status' => 'required|integer',
            'hot_status' => 'required|integer',
            'new_status' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'product-model'.DIRECTORY_SEPARATOR);
        $img = $request->file('main_image');
        $imgName = UploadFile::upload($img,$path);

        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/product-model/".$imgName;

        $text = $request->title.' '.Manufacturer::find($request->manufacturer_id)->name.' '.$request->type.' '.$request->gender;
        foreach ($request->category_ids as $cat){
            $categories[] = $cat*1;
        }
        $alias = SlugConverter::slug($request->title.' '.$request->sub_title);
        $uniqueAlias = ProductModel::where('alias',$alias)->first();
        if($uniqueAlias)  return response()->json(['message' => 'Please change title or SubTitle'],400);

        $data['title'] = $request->title;
        $data['sub_title'] = $request->sub_title;
        $data['manufacturer_id'] = $request->manufacturer_id;
        $data['category_ids'] = $categories;
        $data['alias'] = $alias;
        $data['main_image'] = $image;
        $data['short_description'] = $request->short_description;
        $data['long_description'] = $request->long_description;
//        $data['description_shortened'] = Str::limit($request->long_description, 87,'...');
        $data['price'] = $request->price;
        $data['top_status'] = $request->top_status;
        $data['hot_status'] = $request->hot_status;
        $data['new_status'] = $request->new_status;
        $data['status'] = $request->status;
        $data['bulk_quantity'] = $request->bulk_quantity;
        $data['bulk_percent'] = $request->bulk_percent;
        $data['offerable'] = $request->offerable;
        $data['watermark'] = $request->watermark;
        $data['type'] = $request->type;
        $data['gender'] = $request->gender;
        $data['text'] = $text;
        $productModel = ProductModel::create($data);
        if($productModel){
            return response()->json($productModel,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
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
        $model = ProductModel::findOrFail($id);
        $request->validate([
            'title' => 'required|max:255|min:2',
            'sub_title' => 'required|max:255|min:2',
            'short_description' => 'required|max:255|min:2',
            'type' => 'required',
            'gender' => 'required',
            'long_description' => 'required|max:255|min:2',
            'manufacturer_id' => 'required',
            'category_ids' => 'required|array',
            'price' => 'required|integer',
            'offerable' => 'required|integer',
            'top_status' => 'required|integer',
            'hot_status' => 'required|integer',
            'new_status' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'product-model'.DIRECTORY_SEPARATOR);
        $img = $request->file('main_image');
        if($img){
            $imgName = UploadFile::upload($img,$path);

            if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
            $image = "/storage/product-model/".$imgName;

            $productModelImage = str_replace('/storage', '', $model->main_image);
            Storage::delete('/public' . $productModelImage);

            $data['main_image'] = $image;
        }


        $text = $request->title.' '.Manufacturer::find($request->manufacturer_id)->name.' '.$request->type.' '.$request->gender;
        foreach ($request->category_ids as $cat){
            $categories[] = $cat*1;
        }
        $alias = SlugConverter::slug($request->title.' '.$request->sub_title);
        $uniqueAlias = ProductModel::where('alias',$alias)->first();
        if($uniqueAlias && $uniqueAlias->id != $id)  return response()->json(['message' => 'Please change title or SubTitle'],400);

        $data['title'] = $request->title;
        $data['sub_title'] = $request->sub_title;
        $data['manufacturer_id'] = $request->manufacturer_id;
        $data['category_ids'] = $categories;
        $data['alias'] = $alias;
        $data['short_description'] = $request->short_description;
        $data['long_description'] = $request->long_description;
//        $data['description_shortened'] = Str::limit($request->long_description, 87,'...');
        $data['price'] = $request->price;
        $data['top_status'] = $request->top_status;
        $data['hot_status'] = $request->hot_status;
        $data['new_status'] = $request->new_status;
        $data['status'] = $request->status;
        $data['bulk_quantity'] = $request->bulk_quantity;
        $data['bulk_percent'] = $request->bulk_percent;
        $data['offerable'] = $request->offerable;
        $data['type'] = $request->type;
        $data['gender'] = $request->gender;
        $data['text'] = $text;

        $result = $model->update($data);
        if($result){
            return response()->json($model->fresh(),200);
        }
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
        $productModel = ProductModel::find($id);
        if($productModel){
            $productImage = str_replace('/storage', '', $productModel->main_image);
            Storage::delete('/public' . $productImage);
            if($productModel->delete()) return response()->json($id,200);
        }
        return response()->json(['message' => 'Product Model not found'],404);
    }

    public function checkAlias($title,$subTitle,$id=null)
    {
        $alias = SlugConverter::slug($title.' '.$subTitle);
        $uniqueAlias = ProductModel::where('alias',$alias)->first();
        if($id){
            if($uniqueAlias && $uniqueAlias->id != $id)  return response()->json(['message' => 'Please change title or SubTitle'],400);
            return response()->json(1,200);
        }
        if($uniqueAlias)  return response()->json(['message' => 'Please change title or SubTitle'],400);
        return response()->json(1,200);
    }

}
