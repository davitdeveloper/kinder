<?php


namespace App\Http\View\Composers;


use App\Models\ProductCategory;
use Illuminate\View\View;

class HomeProductComposer
{
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $babyProducts = ProductCategory::find(ProductCategory::BABY)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->whereHas('products')
            ->limit(15)
            ->with('products','categories')
            ->get()->toArray();
        $toddlerProducts = ProductCategory::find(ProductCategory::TODDLER)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->whereHas('products')
            ->limit(15)
            ->with('products','categories')
            ->get()->toArray();
        $foodProducts = ProductCategory::find(ProductCategory::BABY_FOOD)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->whereHas('products')
            ->limit(15)
            ->with('products','categories')
            ->get()->toArray();
        $careProducts = ProductCategory::find(ProductCategory::BABY_CARE)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->whereHas('products')
            ->limit(15)
            ->with('products','categories')
            ->get()->toArray();
        $accessoriesProducts = ProductCategory::find(ProductCategory::ACCESSORIES)
            ->models()
            ->where('top_status',1)
            ->where('status',1)
            ->whereHas('products')
            ->limit(15)
            ->with('products','categories')
            ->get()->toArray();
        $products = [
            'clothes0_3' => array_chunk ( $babyProducts, 3, $preserve_keys = FALSE  ),
            'clothes3+' => array_chunk ( $toddlerProducts, 3, $preserve_keys = FALSE  ),
            'food' => array_chunk ( $foodProducts, 3, $preserve_keys = FALSE  ),
            'babyCare' => array_chunk ( $careProducts, 3, $preserve_keys = FALSE  ),
            'accessories' => array_chunk ( $accessoriesProducts, 3, $preserve_keys = FALSE  ),
        ];
        $view->with('products', $products);
    }
}
