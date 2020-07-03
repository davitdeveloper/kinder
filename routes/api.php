<?php

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/testt', function () {
   return response()->json(ProductCategory::all()->toArray(),200);
});

//Users
Route::get('/profile/users/{role?}', 'Dashboard\UserController@index');
Route::post('/profile/user/create', 'Dashboard\UserController@store');
Route::put('/profile/user/update/{id}', 'Dashboard\UserController@update');
Route::delete('/profile/user/delete/{id}', 'Dashboard\UserController@destroy');
Route::get('/profile/distributors', 'Dashboard\UserController@getDistributors');
Route::get('/profile/get-distributor-info/{id}', 'Dashboard\UserController@getDistributor');
Route::put('/profile/update-distributor-info/{id}', 'Dashboard\UserController@updateDistributor');

//Contracts
Route::get('/profile/contracts', 'Dashboard\ContractController@index');
Route::post('/profile/contract/create', 'Dashboard\ContractController@store');
Route::put('/profile/contract/update/{id}', 'Dashboard\ContractController@update');
Route::delete('/profile/contract/delete/{id}', 'Dashboard\ContractController@destroy');
Route::get('/profile/contract/search-dist', 'Dashboard\ContractController@searchDist');

//ArticleCategory
Route::get('/profile/article-categories', 'Dashboard\ArticleCategoryController@index');
Route::post('/profile/article-category/create', 'Dashboard\ArticleCategoryController@store');
Route::put('/profile/article-category/update/{id}', 'Dashboard\ArticleCategoryController@update');
Route::delete('/profile/article-category/delete/{id}', 'Dashboard\ArticleCategoryController@destroy');

//Article
Route::get('/profile/articles', 'Dashboard\ArticleController@index');
Route::put('/profile/article/update/{id}', 'Dashboard\ArticleController@update');
Route::delete('/profile/article/delete/{id}', 'Dashboard\ArticleController@destroy');

//Tags
Route::get('/profile/tags', 'Dashboard\TagController@index');
Route::post('/profile/tag/create', 'Dashboard\TagController@store');
Route::put('/profile/tag/update/{id}', 'Dashboard\TagController@update');
Route::delete('/profile/tag/{id}', 'Dashboard\TagController@destroy');

//Manufacturers
Route::get('/profile/manufacturers', 'Dashboard\ManufacturerController@index');
Route::post('/profile/manufacturer/create', 'Dashboard\ManufacturerController@store');
Route::put('/profile/manufacturer/update/{id}', 'Dashboard\ManufacturerController@update');
Route::delete('/profile/manufacturer/{id}', 'Dashboard\ManufacturerController@destroy');

//Global Sizes
Route::get('/profile/global-sizes', 'Dashboard\GlobalSizeController@index');
Route::post('/profile/global-size/create', 'Dashboard\GlobalSizeController@store');
Route::put('/profile/global-size/update/{id}', 'Dashboard\GlobalSizeController@update');
Route::delete('/profile/global-size/delete/{id}', 'Dashboard\GlobalSizeController@destroy');

//Manufacturer Sizes
Route::get('/profile/manufacturers/sizes', 'Dashboard\SizeController@manufacturersSizesGlobal');
Route::get('/profile/sizes/{type}/{manId}', 'Dashboard\SizeController@index');
Route::post('/profile/size/create', 'Dashboard\SizeController@store');
Route::put('/profile/size/update/{id}', 'Dashboard\SizeController@update');
Route::delete('/profile/size/{id}/{type}', 'Dashboard\SizeController@destroy');

//Colors
Route::get('/profile/colors', 'Dashboard\ColorController@index');
Route::post('/profile/color/create', 'Dashboard\ColorController@store');
Route::put('/profile/color/update/{id}', 'Dashboard\ColorController@update');
Route::delete('/profile/color/{id}', 'Dashboard\ColorController@destroy');

//ProductModel
Route::get('/profile/product-models', 'Dashboard\ProductModelController@index');
Route::post('/profile/product-model/create', 'Dashboard\ProductModelController@store');
Route::put('/profile/product-model/update/{id}', 'Dashboard\ProductModelController@update');
Route::delete('/profile/product-model/{id}', 'Dashboard\ProductModelController@destroy');
Route::get('/profile/product-models/check-alias/{title}/{subTitle}/{id?}', 'Dashboard\ProductModelController@checkAlias');



//Products
Route::get('/profile/products', 'Dashboard\ProductController@index');
Route::post('/profile/product/create', 'Dashboard\ProductController@store');
Route::put('/profile/product/update/{id}', 'Dashboard\ProductController@update');
Route::delete('/profile/product/del-img', 'Dashboard\ProductController@delImg');
Route::delete('/profile/product/{id}', 'Dashboard\ProductController@destroy');
Route::get('/profile/product/search-model', 'Dashboard\ProductController@searchModel');
Route::get('/profile/product/colors', 'Dashboard\ProductController@getColors');
Route::get('/profile/product/sizes/{model_id}/{color}', 'Dashboard\ProductController@getSizes');
Route::get('/profile/product/sizes/get-product/{man_id}/{size_id}/{type}', 'Dashboard\ProductController@getProductForUpdate');
Route::delete('/profile/product/del-img', 'Dashboard\ProductController@delImg');



Route::get('/profile/get-distributor-products/{id}', 'Dashboard\ProductController@getDistributorProducts');

//Model discount
Route::get('/profile/model-discounts', 'Dashboard\ModelDiscountController@index');
Route::post('/profile/model-discount/create', 'Dashboard\ModelDiscountController@store');
Route::put('/profile/model-discount/update/{id}', 'Dashboard\ModelDiscountController@update');
Route::delete('/profile/model-discount/delete/{id}', 'Dashboard\ModelDiscountController@destroy');
Route::get('/profile/model-discount/search-model', 'Dashboard\ModelDiscountController@searchModel');

//Product discount
Route::get('/profile/product-discounts', 'Dashboard\ProductDiscountController@index');
Route::post('/profile/product-discount/create', 'Dashboard\ProductDiscountController@store');
Route::put('/profile/product-discount/update/{id}', 'Dashboard\ProductDiscountController@update');
Route::delete('/profile/product-discount/delete/{id}', 'Dashboard\ProductDiscountController@destroy');
Route::get('/profile/product-discount/search-product', 'Dashboard\ProductDiscountController@searchProduct');

//Ads
Route::get('/profile/ads', 'Dashboard\AdController@index');
Route::put('/profile/ads/update/{id}', 'Dashboard\AdController@update');
Route::delete('/profile/ads/delete/{id}', 'Dashboard\AdController@destroy');

//Sliders
Route::get('/profile/sliders', 'Dashboard\HomeSliderController@index');
Route::post('/profile/slider/create', 'Dashboard\HomeSliderController@store');
Route::put('/profile/slider/update/{id}', 'Dashboard\HomeSliderController@update');
Route::delete('/profile/slider/delete/{id}', 'Dashboard\HomeSliderController@destroy');

//Orders
Route::get('/profile/orders', 'Dashboard\OrderController@index');
Route::get('/profile/order/complete/{id}', 'Dashboard\OrderController@completeOrder');
//Route::delete('/profile/slider/delete/{id}', 'Dashboard\HomeSliderController@destroy');


//Opinions
Route::get('/profile/opinions', 'Dashboard\OpinionController@index');
Route::put('/profile/opinions/update/{id}', 'Dashboard\OpinionController@update');
Route::delete('/profile/opinions/delete/{id}', 'Dashboard\OpinionController@destroy');






// FRONT

//Client profile
Route::get('/app/user/{id}', 'Front\UserController@index');
Route::put('/app/user/update/{id}', 'Front\UserController@update');

Route::get('/app/user/offers/{id}', 'Front\OfferController@index');

//BabySitter
Route::get('/app/baby-sitter/info-for-cv/{id}', 'Front\BabySitterController@getInfoForCv');
Route::post('/app/baby-sitter/create/cv/{id}', 'Front\BabySitterController@createCv');


//Articles
Route::get('/app/articles', 'Front\ArticleController@index');
Route::get('/app/article/comments/{id}', 'Front\ArticleController@getComments');
Route::get('/app/article/{id}', 'Front\ArticleController@show')->where(['id' => '[0-9]']);
Route::get('/app/article/latest', 'Front\ArticleController@latestPosts');
Route::get('/app/article/get-archives', 'Front\ArticleController@getArchives');
Route::get('/app/article/get-articles-tags', 'Front\ArticleController@getArticlesTags');
Route::get('/app/article/categories', 'Front\ArticleController@getCategories');

Route::post('/app/article/comment/{id}', 'Front\CommentController@store');
Route::post('/app/article/comment/reply/{id}', 'Front\ReplyController@store');

Route::get('/app/my-articles/search-category', 'Front\ArticleController@searchCategory');
Route::get('/app/my-articles/search-tags', 'Front\ArticleController@searchTags');
Route::get('/app/my-articles/{id}', 'Front\ArticleController@myArticles');
Route::post('/app/my-article/create', 'Front\ArticleController@store');
Route::put('/app/my-article/update/{id}', 'Front\ArticleController@update');
Route::delete('/app/my-article/delete/{id}', 'Front\ArticleController@destroy');
Route::delete('/app/my-articles/image/{id}', 'Front\ArticleController@delimg');

//Products
Route::get('/app/products/{category?}/{subCategory?}/{subSubCategory?}', 'Front\ProductModelController@index');
Route::get('/app/product/{alias}', 'Front\ProductController@show');

//OwnProduct
Route::get('/app/own-products/{category?}/{subCategory?}/{subSubCategory?}', 'Front\OwnProductController@index');
Route::get('/app/own-product/get-info', 'Front\OwnProductController@getInfo');
Route::get('/app/own-product/show/{alias}', 'Front\OwnProductController@show');
Route::post('/app/own-product/create', 'Front\OwnProductController@store');
Route::post('/app/own-product/up-in-list/{id}/{user_id}', 'Front\OwnProductController@upProductInList');
Route::get('/app/own-product/get-my-product/{id}', 'Front\OwnProductController@getMyProducts');
Route::put('/app/own-product/update/{id}', 'Front\OwnProductController@update');
Route::delete('/app/own-product/del-img/{id}', 'Front\OwnProductController@delImg');
Route::delete('/app/own-product/delete/{id}', 'Front\OwnProductController@destroy');

//Fvaorites
Route::post('/favorites', 'Front\ProductModelController@notLogedUserFavorites');
Route::get('/favorites/{userId}', 'Front\ProductModelController@getFavoriteProducts');
Route::post('/favorites/create/{userId}', 'Front\ProductModelController@createFavoriteProducts');
Route::post('/favorites/add-remove/{userId}', 'Front\ProductModelController@addRemoveFavorite');
Route::delete('/favorites/{productId}/{userId}', 'Front\ProductModelController@deleteFavoriteProduct');

//ShoppingCart
Route::post('/shopping-cart', 'Front\ProductController@notLogedUserCardProducts');
Route::get('/shopping-cart/{userId}', 'Front\ProductController@getCartProducts');
Route::post('/shopping-cart/add/{userId}', 'Front\ProductController@addToCart');
Route::post('/shopping-cart/add-many/{userId}', 'Front\ProductController@addManyToCart');
Route::delete('/shopping-cart/{productId}/{userId}', 'Front\ProductController@deleteCartProduct');

//Offers
Route::post('/app/offer/create/{userId}', 'Front\OfferController@store');

//Orders
Route::post('/profile/order/create', 'Front\OrderController@store');

//Opinions
Route::get('/opinions', 'Front\OpinionController@index');
Route::post('/opinions/{userId}', 'Front\OpinionController@store');
