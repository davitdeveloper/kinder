<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\Gallery;
use App\Models\Tag;
use App\MyHelpers\SlugConverter;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Article::latest()->with(['localization','category','tags','images','user'])->get());
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

//        $request->validate([
//            'title' => 'required|max:255|min:2',
//            'description' => 'required|min:2',
//            'article_category_id' => 'required',
//            'main_image' => 'required|image|mimes:jpeg,jpg,png',
//            'alias' => 'required|min:2|unique:articles,alias',
//            'gallery' => 'array|required',
//            'gallery.*' => 'required|image|mimes:jpeg,jpg,png',
//        ]);
//        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
//        $img = $request->file('main_image');
//        $imgName = UploadFile::upload($img,$path);
//        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
//        $image = "/storage/article/".$imgName;
//        $alias = SlugConverter::slug($request->alias);
//
//        $data['title'] = $request->title;
//        $data['description'] = $request->description;
//        $data['alias'] = $alias;
//        $data['main_image'] = $image;
//        $data['status'] = $request->status;
//        $data['article_category_id'] = $request->article_category_id;
//
//        if(!ArticleCategory::find($request->article_category_id)) return response()->json(['message' => 'Something went wrong'],400);
//
//        DB::beginTransaction();
//
//        $article = Article::create($data);
//
//        if($article){
//            if($request->tags){
//                $tags = $article->tags()->sync($request->tags);
//                if(!$tags){
//                    DB::rollBack();
//                    return response()->json(['message' => 'Something went wrong'],400);
//                }
//            }
//            $galleries = $request->gallery;
//            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
//            foreach ($galleries as $item){
//                $imgName = UploadFile::upload($item,$path);
//                if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
//                $image = "/storage/article/".$imgName;
//                $aimg = ArticleImage::create([
//                    'article_id' => $article->id,
//                    'image' => $image
//                ]);
//                if(!$aimg){
//                    DB::rollBack();
//                    return response()->json(['message' => 'Something went wrong'],400);
//                }
//            }
//            DB::commit();
//            return response()->json($article->fresh()->load(['localization','category','tags','images']),200);
//        }
//        DB::rollBack();
//        return response()->json(['message' => 'Something went wrong'],400);
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
        $article = Article::find($id);
        if(!$article) return response()->json(['message' => 'Article not found'],404);;
        $article->update($request->only('status'));

        return response()->json($article->fresh()->load(['localization','category','tags','images','user']),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if ($article){
            foreach ($article->images as $img) {
                $image = str_replace('/storage', '', $img->image);
                Storage::delete('/public' . $image);
            }
            $mainImage = str_replace('/storage', '', $article->main_image);
            Storage::delete('/public' . $mainImage);
            if(Article::destroy($id)) return response()->json($id,200);
            return response()->json(['message' => 'Something went wrong'],400);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
