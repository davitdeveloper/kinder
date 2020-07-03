<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Tag::with('localization')->get());
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
            '*.name' => 'required|max:255|min:2|unique:tags,name',
        ]);
        foreach($request->all() as $tag){
            $tags[] = Tag::create($tag);
        }
        return response()->json($tags,200);
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
        $request->validate([
            'name' => 'required|max:255|min:2|unique:tags,name,'.$id,
        ]);
        $tag = Tag::find($id);
        if($tag){
            $tag->update($request->only('name'));
            return response()->json($tag->fresh(),200);
        }
        return response()->json(['message' => 'Tag not found!'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            if($tag->articles){
                $tag->articles()->sync([]);
            }
            $tag->delete();
            return response()->json($id, 200);
        }
        return response()->json(['message' => 'Tag not found!'],404);
    }
}
