<?php


namespace App\Http\View\Composers;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class UserComposer
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

                    //        ? auth()->user()->load(['favorites','shopProducts' => function($q){$q->with('product','color')->withPivot('option_id','id','quantity');}]) : auth()->user()
                    //        |
                    //        |
                    //        |
                    //       \/
        $user = auth()->user();
        if(auth()->check()){
            $user = auth()->user()->load(['favoriteProducts','shopProducts' => function($q){
                $q->with('model','color')->withPivot('product_id','id','quantity');
            }]);
        }
        $view->with('user', $user);
    }
}
