<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\MyHelpers\SlugConverter;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(ArticleCategory::with('localization')->get());
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
            'name' => 'required|max:255|min:2|unique:article_categories,name',
            'description' => 'required|min:2',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'alias' => 'required|unique:article_categories,alias',
            'status' => 'required'
        ]);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article-category'.DIRECTORY_SEPARATOR);
        $img = $request->file('image');

        $imgName = UploadFile::upload($img,$path);
        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/article-category/".$imgName;
        $alias = SlugConverter::slug($request->alias);

        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        $data['alias'] = $alias;
        $data['image'] = $image;

        $category = ArticleCategory::create($data);

        if(!$category){
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json($category->fresh(), 200);

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
        if(!ArticleCategory::find($id)) return response()->json(['message' => 'Something went wrong'],400);
        if(!$request->alias){
            $request->merge(['alias' => SlugConverter::slug($request->name)]);
        }
        $request->validate([
            'name' => 'required|max:255|min:2|unique:article_categories,name,'.$id,
            'description' => 'required|min:2',
            'alias' => 'unique:article_categories,alias,'.$id,
            'status' => 'required'
        ]);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article-category'.DIRECTORY_SEPARATOR);
        $img = $request->file('image');
        if($img){
            $imgName = UploadFile::upload($img,$path);
            if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
            $image = "/storage/article-category/".$imgName;

            $categoryImage = str_replace('/storage', '', ArticleCategory::find($id)->image);
            Storage::delete('/public' . $categoryImage);

            $data['image'] = $image;
        }


        if($request->alias){
            $alias = SlugConverter::slug($request->alias);
        }
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        $data['alias'] = $alias;

        $category = ArticleCategory::find($id)->update($data);

        if(!$category){
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json(ArticleCategory::find($id), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = ArticleCategory::findOrFail($id);
        $categoryImage = str_replace('/storage', '', $category->image);
        Storage::delete('/public' . $categoryImage);
        if($category->delete()) return response()->json($id,200);
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
