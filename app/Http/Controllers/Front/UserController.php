<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $user = User::where('id',$id)->select('id','name','email','image')->first()->load(['childrens']);
        if($user) return response()->json($user,200);
        return response()->json(['message' => 'User not found'],404);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);
        $user->childrens()->delete();
        $passwordRequired = $request->input('password') ? "required|string|min:6|confirmed" : '';
        $childsRequired = $request->input('childs') ? "required|array" : '';
        $childsItem = $request->input('childs') ? "required" : '';
        $request->validate([
            'name' => 'required|max:255|min:2',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => $passwordRequired,
            'childs' => $childsRequired,
            'childs.*.name' => $childsItem,
            'childs.*.birthday' => $childsItem,
        ]);

        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR);
        $img = $request->file('image');
        if ($img) {
            $imgName = UploadFile::upload($img,$path);

            if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
            $image = "/storage/user/".$imgName;
            $data['image'] = $image;
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        if($request->password !== 'undefined' || $request->password) $data['password'] = Hash::make($request->password);
        $result = $user->update($data);
        if($result){
            if($request->childs){
                $user->childrens()->createMany($request->childs);
            }
            return response()->json($user->fresh()->load('childrens'),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
