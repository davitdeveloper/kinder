<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ManufacturerAccessorySize;
use App\Models\ManufacturerPantSize;
use App\Models\ManufacturerShoeSize;
use App\Models\ManufacturerTopSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($type,$manId)
    {
        $msz = [];
        $req = Size::where('type',$type);
        $model = 'App\Models\Manufacturer'.$type.'Size';
        if($manId == 'null' || $manId == 'NULL' || !$manId) return response()->json(['message' => 'Something went wrong'],400);
        $manSizes = $model::where('manufacturer_id',$manId)->get();
        if(!$manSizes) return response()->json(Size::where('type',$type)->get(),200);
        foreach ($manSizes as $size){
            $msz[] = $size->size_id;
        }
        foreach ($msz as $s){
            $req = $req->where('id','!=',$s);
        }
        $sizes = $req->get();
        return response()->json($sizes,200);
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
            '*' => 'required|array',
            '*.manufacturer_id' => 'required',
            '*.size_id' => 'required',
            '*.type' => ['required',Rule::in(['Top','Shoe','Accessory','Pant'])],
        ]);
        $top = [];
        $pant = [];
        $shoe = [];
        $accessory = [];
        foreach ($request->all() as $size){
            $model = 'App\Models\Manufacturer'.$size['type'].'Size';
            if($size['type'] === 'Top'){
                $t = $model::create($size);
                $top[] = $t->load(['manufacturer','size']);
            }
            if($size['type'] === 'Pant') {
                $p = $model::create($size);
                $pant[] = $p->load(['manufacturer', 'size']);
            }
            if($size['type'] === 'Shoe'){
                $sh = $model::create($size);
                $shoe[] = $sh->load(['manufacturer', 'size']);
            }

            if($size['type'] === 'Accessory'){
                $ac = $model::create($size);
                $accessory[] = $ac->load(['manufacturer', 'size']);
            }
        }
        if(count($top)) return response()->json($top,200);
        if(count($pant)) return response()->json($pant,200);
        if(count($shoe)) return response()->json($shoe,200);
        if(count($accessory)) return response()->json($accessory,200);
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
            'manufacturer_id' => 'required',
            'size_id' => 'required',
            'type' => ['required',Rule::in(['Top','Shoe','Accessory','Pant'])],
        ]);
        $model = 'App\Models\Manufacturer'.$request->type.'Size';
        $size = $model::fibdOrFail($id);
        $result = $size->update($request->all());
        if(!$result) return response()->json(['message' => 'Something went wrong'],400);
        return response()->json($size->fresh()->load(['manufacturer','size']),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id,$type)
    {
        $model = 'App\Models\Manufacturer'.$type.'Size';
        $size = $model::findOrFail($id);
        $size->delete();
        return response()->json($size,200);
    }

    public function manufacturersSizesGlobal()
    {
        $sizes = [];

        $top = ManufacturerTopSize::with('manufacturer','size')->get()->toArray();
        $shoe = ManufacturerShoeSize::with('manufacturer','size')->get()->toArray();
        $pant = ManufacturerPantSize::with('manufacturer','size')->get()->toArray();
        $accessory = ManufacturerAccessorySize::with('manufacturer','size')->get()->toArray();

        $data1 = array_merge($sizes,$top);
        $data2 = array_merge($data1,$shoe);
        $data3 = array_merge($data2,$pant);
        $sizes = array_merge($data3,$accessory);

        return response()->json($sizes,200);
    }
}
