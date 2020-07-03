<?php


namespace App\Http\View\Composers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class MenuComposer
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
        // Active locale language
//        $locale = App::getLocale();

        //Get products of this local language translation
//        $cat = ProductCategory::with(['localization'=>function($q) use($locale){
//            $q->where('lang', $locale);
//        }])->get()->toArray();

        $cat = ProductCategory::all()->toArray();

        //Create recursive tree
//        $menu = (new ProductCategory())->createTree($cat);
        $view->with('menu', $cat);
    }
}
