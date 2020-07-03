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
use Illuminate\Support\Facades\Storage;

class UpdateProductRequest extends FormRequest
{
    public $items = [];

    public $pictures = [];

    public $id = '';

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

    public function updateProduct($id)
    {
        DB::beginTransaction();
        foreach ($this->input('products') as $item) {
            $size = $item['size_id'] ? Size::find($item['size_id'])->value : '';
            $text = ProductModel::find($item['model_id'])->title.' '.Color::find($item['color_id'])->name.' '.$size;
            $arr = Arr::add($item['info'],'text',$text);
            $prod = Product::findOrFail($id);
            $prod->update($arr);
            $product = $prod->fresh();
            if($size){
                $product->size()->associate($item['size_id']);
            }
            $product->color()->associate($item['color_id']);
            $product->model()->associate($item['model_id']);
            if($product->images){
                foreach ($product->images as $item){
                    $prodImage = str_replace('/storage', '', $item->image);
                    Storage::delete('/public' . $prodImage);
                }
                $img = $product->images()->createMany($this->pictures) ?: null;
                $product->save();
            }
            $product->distributors()->sync([]);
            foreach ($this->distributors as $dist){
                $product->distributors()->attach($dist['id'],['price' => $dist['price'],'quantity' => $dist['quantity']]);
            }
            $this->items[] = $product->load(['model','color','size','images']);
        }
        if(!$img){
            DB::rollBack();
            return response()->json('Something went wrong',400);
        }
        DB::commit();
        return response()->json($this->items, 200);
    }

    public function uploadImages()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR);

        if($this->images) foreach ($this->images as $file) array_push($this->pictures, ['image' => "/storage/product/".UploadFile::upload($file, $path)]);

        return $this;
    }
}
