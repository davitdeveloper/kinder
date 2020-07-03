<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




use App\Http\Middleware\LocaleMiddleware;
use App\Models\Article;
use Intervention\Image\Facades\Image;

//Route::get('/test', function()
//{
//    $img = Image::make(public_path('storage/contract/111.png'));
//    /* insert watermark at bottom-right corner with 10px offset */
//    $watermark = Image::make('storage/contract/watermark.png');
//    $img->insert($watermark, 'bottom-right', 10, 10);
//
//    $img->save(public_path('storage/contract/taza.png'));
//
//    dd('saved image successfully.');
//});
//Route::auth(['verify' => true]);

//Route::get('/sign-in/github','Auth\LoginController@github');
//Route::get('/sign-in/github/redirect','Auth\LoginController@githubRedirect');
//
//Route::get('/sign-in/pinterest','Auth\LoginController@pinterest');
//Route::get('/sign-in/pinterest/redirect','Auth\LoginController@pinterestRedirect');

// Route::get('/', function () {
//     return redirect('/'. App\Http\Middleware\LocaleMiddleware::getLocale());
// });

// Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){

// });



Auth::routes();

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

//Route::get('/home', 'HomeController@index')->name('home');
