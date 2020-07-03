<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(HomeSlider::all(),200);
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
            'rang' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'status' => 'required|boolean',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'slider'.DIRECTORY_SEPARATOR);
        $img = $request->file('image');
        if (!$img) {
            return response()->json(['message' => 'Something went wrong'],400);
        }
        $imgName = UploadFile::upload($img,$path);

        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/slider/".$imgName;


        $data['rang'] = $request->rang;
        $data['status'] = $request->status;
        $data['image'] = $image;

        $slider = HomeSlider::create($data);
        if($slider){
            return response()->json($slider,200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
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
        $slider = HomeSlider::findOrFail($id);
        $request->validate([
            'rang' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'slider'.DIRECTORY_SEPARATOR);
        $img = $request->file('image');
        if($img){
            $imgName = UploadFile::upload($img,$path);

            if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
            $image = "/storage/slider/".$imgName;

            $sliderImage = str_replace('/storage', '', $slider->image);
            Storage::delete('/public' . $sliderImage);

            $data['image'] = $image;
        }

        $data['rang'] = $request->rang;
        $data['status'] = $request->status;

        $result = $slider->update($data);
        if($result){
            return response()->json($slider->fresh(),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $slider = HomeSlider::findOrFail($id);
        $sliderImage = str_replace('/storage', '', $slider->image);
        Storage::delete('/public' . $sliderImage);
        if($slider->delete()) return response()->json($id,200);
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
