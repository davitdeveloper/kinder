<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $manufacturers = Manufacturer::select(['id','name','description','logo'])->get();
        if($manufacturers) return response()->json($manufacturers,200);
        return response()->json(['message' => 'Something went wrong'],400);
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
            'name' => 'required|max:255|min:2',
            'logo' => 'required|image|mimes:jpeg,jpg,png',
            'description' => 'required|min:2',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'manufacturer'.DIRECTORY_SEPARATOR);
        $img = $request->file('logo');
        if (!$img) {
            return response()->json(['message' => 'Something went wrong'],400);
        }
        $imgName = UploadFile::upload($img,$path);

        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
        $image = "/storage/manufacturer/".$imgName;


        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['logo'] = $image;

        $manufacturer = Manufacturer::create($data);
        if($manufacturer){
            return response()->json($manufacturer,200);
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
        $manufacturer = Manufacturer::find($id);
        if(!$manufacturer) return response()->json(['message' => 'Manufacturer not found'], 404);
        $request->validate([
            'name' => 'required|max:255|min:2',
            'description' => 'required|min:2',
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'manufacturer'.DIRECTORY_SEPARATOR);
        $img = $request->file('logo');
        if ($img) {
            $imgName = UploadFile::upload($img,$path);
            if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
            $image = "/storage/manufacturer/".$imgName;

            $manufacturerLogo = str_replace('/storage', '', $manufacturer->logo);
            Storage::delete('/public' . $manufacturerLogo);

            $data['logo'] = $image;
        }

        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $result = $manufacturer->update($data);
        if($result){
            return response()->json($manufacturer->fresh(),200);
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
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturerLogo = str_replace('/storage', '', $manufacturer->logo);
        Storage::delete('/public' . $manufacturerLogo);
        if($manufacturer->delete()) return response()->json($id,200);
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
