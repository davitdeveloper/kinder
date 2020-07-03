<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Distributor;
use App\Models\User;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Contract::with(['user'=>function($q){
            $q->with('distributor');
        }])->get());
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
            'user_id' => 'required',
            'name' => 'required|max:255|min:2',
            'date_start' => 'required',
            'date_end' => 'required',
            'status' => 'required',
            'document' => 'required|file',
        ]);
        if(!User::find($request->user_id)) return response()->json(['message' => 'User not found'],404);
        if(!User::find($request->user_id)->distributor) return response()->json(['message' => 'Something went wrong'],400);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'contract'.DIRECTORY_SEPARATOR);
        $doc = $request->file('document');
        if (!$doc) {
            return response()->json(['message' => 'Something went wrong'],400);
        }
        $docName = UploadFile::upload($doc,$path);

        if(!$docName) return response()->json(['message' => 'Something went wrong'],400);
        $document = "/storage/contract/".$docName;


        $data['user_id'] = $request->user_id;
        $data['name'] = $request->name;
        $data['date_start'] = $request->date_start;
        $data['date_end'] = $request->date_end;
        $data['status'] =$request->status;
        $data['document'] = $document;

        $contract = Contract::create($data);
        if($contract){
            return response()->json($contract->load(['user'=>function($q){
                    $q->with('distributor');
                }]),200);
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
        $contract = Contract::findOrFail($id);
        $request->validate([
            'user_id' => 'required',
            'name' => 'required|max:255|min:2',
            'date_start' => 'required',
            'date_end' => 'required',
            'status' => 'required',
        ]);
        $user = User::findOrFail($request->user_id);
        if(!$user->distributor) return response()->json(['message' => 'Something went wrong'],400);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'contract'.DIRECTORY_SEPARATOR);
        $doc = $request->file('document');
        if ($doc) {
            $docName = UploadFile::upload($doc,$path);

            if(!$docName) return response()->json(['message' => 'Something went wrong'],400);
            $document = "/storage/contract/".$docName;

            $distDoc = str_replace('/storage', '', $contract->document);
            Storage::delete('/public' . $distDoc);

            $data['document'] = $document;
        }

        $data['user_id'] = $request->user_id;
        $data['name'] = $request->name;
        $data['date_start'] = $request->date_start;
        $data['date_end'] = $request->date_end;
        $data['status'] =$request->status;

        if($contract->update($data)){
            return response()->json($contract->fresh()->load(['user'=>function($q){
                $q->with('distributor');
            }]),200);
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
        $contract = Contract::findOrFail($id);
        $doc = str_replace('/storage', '', $contract->document);
        Storage::delete('/public' . $doc);
        if($contract->delete()) return response()->json($id,200);
        return response()->json(['message' => 'Manufacturer not found'],404);
    }

    public function searchDist(Request $request)
    {
        $distributors = Distributor::where('company', 'LIKE', "%$request->search%")->with('user')->take(10)->get()->toArray();
        return response()->json($distributors,200);
    }
}
