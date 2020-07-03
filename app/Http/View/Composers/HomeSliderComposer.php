<?php


namespace App\Http\View\Composers;

use App\Models\HomeSlider;
use Illuminate\View\View;

class HomeSliderComposer
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
        $sliders = HomeSlider::where('status',1)->limit(5)->get();
        $view->with('sliders', $sliders);
    }
}
