<?php

namespace App\Http\Requests;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Size;
use App\MyHelpers\UploadFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateProductRequest extends FormRequest
{
    public $items = [];

    public $pictures = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $size = isset($this->products[0]['size_id']);
        $sizeValidate = 'required|integer';
        if(!$size){
            $sizeValidate = '';
        }
        return [
            'products' => 'required|array',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,jpg,png',
            'distributors' => 'required|array',
            'distributors.*.id' => 'required|integer',
            'distributors.*.price' => 'required|integer',
            'distributors.*.quantity' => 'required|integer',
            'products.*.model_id' => 'required|integer',
            'products.*.size_id' => $sizeValidate,
            'products.*.color_id' => 'required|integer',
            'products.*.info.price' => 'required|integer',
            'products.*.info.quantity' => 'required|integer',
            'products.*.info.SCU' => 'required',
        ];
    }

    public function createProducts()
    {
        DB::beginTransaction();
        foreach ($this->input('products') as $item) {
            $size = $item['size_id'] ? Size::find($item['size_id'])->value : '';
            $text = ProductModel::find($item['model_id'])->title.' '.Color::find($item['color_id'])->name.' '.$size;
            $arr = Arr::add($item['info'],'text',$text);
            $product = Product::create($arr);
            if($size){
                $product->size()->associate($item['size_id']);
            }
            $product->color()->associate($item['color_id']);
            $product->model()->associate($item['model_id']);
            $img = $product->images()->createMany($this->pictures) ?: null;
            $product->save();
            foreach ($this->distributors as $dist){
                $product->distributors()->attach($dist['id'],['price' => $dist['price'],'quantity' => $dist['quantity']]);
            }
            $this->items[] = $product->load(['model','color','size','images']);
        }
        if(!$img){
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong'],400);
        }
        DB::commit();
        return response()->json($this->items, 200);
    }

    public function uploadImages()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR);

         abort_if(!$this->images, 422, 'There are no images selected!');

         foreach ($this->images as $file) array_push($this->pictures, ['image' => "/storage/product/".UploadFile::upload($file, $path)]);

         return $this;
    }
}
