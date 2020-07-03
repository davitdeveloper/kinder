<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\Comment;
use App\Models\Tag;
use App\MyHelpers\SlugConverter;
use App\MyHelpers\UploadFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $perPage = $request->perpage ? $request->perpage : 5;
        $search = $request->search ? $request->search : null;
        $dates = $request->dates ? $request->dates : null;
        $category = $request->category ? $request->category : null;
        $tag = $request->tag ? $request->tag : null;
        if ($search){
            $req = Article::search($search)->where('status',1);
        }
        else{
            $req = Article::where('status',1);
        }

        if ($dates){
            foreach ($dates as $date) {
                $arr = explode(' ', $date);
                $req = $req->filter(['month' => $arr[0], 'year' => $arr[1]*1]);
            }
        }

        if ($category) $req = $req->whereHas('category',function($q) use($category){
            $q->where('alias',$category);
        });
        if ($tag) $req = $req->whereHas('tags',function($q) use($tag){
            $q->where('name',$tag);
        });
        $articles = $req->latest()->with(['localization','tags'])->paginate($perPage,'*','',$page);
        return response()->json($articles,200);
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
            'title' => 'required|max:255|min:2',
            'description' => 'required|min:2',
            'article_category_id' => 'required',
            'main_image' => 'required|image|mimes:jpeg,jpg,png',
            'gallery' => 'array|required',
            'gallery.*' => 'required|image|mimes:jpeg,jpg,png',
            'user_id' => 'required|exists:users,id',
        ]);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
        $img = $request->file('main_image');
        $imgName = UploadFile::upload($img,$path);
        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/article/".$imgName;
        $alias = SlugConverter::slug($request->title);

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['alias'] = $alias;
        $data['user_id'] = $request->user_id;
        $data['main_image'] = $image;
        $data['article_category_id'] = $request->article_category_id;

        if(!ArticleCategory::find($request->article_category_id)) return response()->json(['message' => 'Something went wrong'],400);

        DB::beginTransaction();

        $article = Article::create($data);

        if($article){
            if($request->tags){
                $tags = $article->tags()->sync($request->tags);
                if(!$tags){
                    DB::rollBack();
                    return response()->json(['message' => 'Something went wrong'],400);
                }
            }
            $galleries = $request->gallery;
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
            foreach ($galleries as $item){
                $imgName = UploadFile::upload($item,$path);
                if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                $image = "/storage/article/".$imgName;
                $aimg = ArticleImage::create([
                    'article_id' => $article->id,
                    'image' => $image
                ]);
                if(!$aimg){
                    DB::rollBack();
                    return response()->json(['message' => 'Something went wrong'],400);
                }
            }
            DB::commit();
            return response()->json($article->fresh()->load(['localization','category','tags','images']),200);
        }
        DB::rollBack();
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $article = Article::find($id);
        if($article)  return response()->json($article->load(['comments' => function($q){
            $q->with(['user','replies' => function($q){
                $q->with('user');
            }]);
        }]),200);
        return response()->json(['message' => 'Article not found'],404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        $request->validate([
            'title' => 'required|max:255|min:2',
            'description' => 'required|min:2',
            'article_category_id' => 'required',
            'main_image' => 'required',
            'gallery' => 'array|required',
            'user_id' => 'required|exists:users,id',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
        $img = $request->file('main_image');
        if (!$img) {
            return response()->json(['message' => 'Something went wrong'],400);
        }

        $imgName = UploadFile::upload($img,$path);
        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/article/".$imgName;

        $articleImage = str_replace('/storage', '', Article::find($id)->main_image);
        Storage::delete('/public' . $articleImage);

        $alias = SlugConverter::slug($request->title);

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['alias'] = $alias;
        $data['user_id'] = $request->user_id;
        $data['main_image'] = $image;
        $data['article_category_id'] = $request->article_category_id;

        $a = Article::find($id)->update($data);
        $article = Article::find($id);
        if($a){
            if($request->tags){
                $article->tags()->sync($request->tags);
            }
        }


        if($article){
            foreach ($article->images as $item){
                $articleImage = str_replace('/storage', '', $item->image);
                Storage::delete('/public' . $articleImage);
            }
            $galleries = $request->file('gallery');
            foreach ($galleries as $item){
                $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'article'.DIRECTORY_SEPARATOR);
                $imgName = UploadFile::upload($item,$path);
                if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                $image = "/storage/article/".$imgName;
                ArticleImage::create([
                    'article_id' => $article->id,
                    'image' => $image
                ]);
            }
        }
        return response()->json($article->fresh()->load(['localization','category','tags','images']),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function latestPosts()
    {
        return response()->json(Article::where('status',1)->with('localization')->latest()->limit(2)->get(),200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArchives()
    {
        $archives = Article::archives();
        $data=[];

        foreach ($archives as $key => $item){
            $data[$key]['year'] = $item['year'];
            $data[$key]['month'] = $item['month'];
            $data[$key]['monthHY'] = $item['monthHY'];
            $data[$key]['number'] = $item['number'];
        }
        return response()->json($data,200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticlesTags()
    {
        return response()->json(Tag::all(),200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        return response()->json(ArticleCategory::where('status',1)->get(),200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function myArticles($id)
    {
        return response()->json(Article::with(['localization','category','tags','images'])->get());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delimg($id)
    {
        $image = ArticleImage::find($id);
        $productImage = str_replace('/storage', '', $image->image);
        Storage::delete('/public' . $productImage);
        if($image->delete()) return response()->json('Image deleted successful',200);
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchCategory(Request $request){
//        dd(6);
        $categories = ArticleCategory::where('name', 'LIKE', "%$request->search%")->take(5)->get()->toArray();
        return response()->json($categories,200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTags(Request $request){
        $tags = Tag::where('name', 'LIKE', "%$request->search%")->take(10)->get()->toArray();
        return response()->json($tags,200);
    }

}
