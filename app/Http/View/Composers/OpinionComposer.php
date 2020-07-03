<?php


namespace App\Http\View\Composers;
use App\Models\Opinion;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class OpinionComposer
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
        $opinions = Opinion::latest()->limit(9)->get()->chunk(3);
        $view->with('opinions', $opinions);
    }
}
