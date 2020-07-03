<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Role;
use App\Models\User;
use App\MyHelpers\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($role=null)
    {
//        makeVisible('password')
//        $role = $request->role ? $request->role : null;
        if ($role){
            $users = User::where('role_id',$role)->with('distributor','role')->get();
            return response()->json($users,200);
        }
        $users =  User::with('distributor','role')->get();

        return response()->json($users,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $distributorCompany = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $distributorDirector = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $distributorPhone = $request->input('role_id') == 3 ? 'required|min:6' : '';
        $distributorAddress = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $request->validate([
            'distributor' => 'array',
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6','confirmed'],
            'role_id' => ['required', 'integer'],
            'distributor.company' => $distributorCompany,
            'distributor.director' => $distributorDirector,
            'distributor.phone' => $distributorPhone,
            'distributor.address' => $distributorAddress,
        ]);
        $userData =  $request->except('distributor');
        $password = Hash::make($request->input('password'));
        $userData['password'] = $password;
        $user = User::create($userData);

        if($user){
            if ($request->role_id == 3) {
                $imageValid = $request->validate([
                    'distributor.logo' => 'required|image|mimes:jpeg,jpg,png',
                ]);

                if($imageValid){
                    $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'distributor'.DIRECTORY_SEPARATOR);
                    $img = $request->file('distributor.logo');
                    if (!$img) {
                        if(!empty($request->distributor->logo)){
                            $image = $request->distributor->logo;
                        }
                        else{
                            return response()->json(['message' => 'Something went wrong'],400);
                        }
                    }
                    else{
                        $imgName = UploadFile::upload($img,$path);

                        if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                        $image = "/storage/distributor/".$imgName;
                    }
                    $data['company'] = $request->distributor['company'];
                    $data['director'] = $request->distributor['director'];
                    $data['address'] = $request->distributor['address'];
                    $data['phone'] = $request->distributor['phone'];
                    $data['tax_code'] = $request->distributor['tax_code'];
                    $data['bank_name'] = $request->distributor['bank_name'];
                    $data['iban'] = $request->distributor['iban'];
                    $data['website'] = $request->distributor['website'];
                    $data['description'] = $request->distributor['description'];
                    if(!empty($request->distributor['logo'])){
                        $data['logo'] = $image;
                    }
                    $user->distributor()->create($data);
                    return response()->json($user->fresh()->load(['role','distributor']),200);
                }
            }
            return response()->json($user->load(['role']),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $role = $user->role_id == User::DISTRIBUTOR ? User::DISTRIBUTOR  : null ;
        $passwordRequired = $request->input('password') ? "required|string|min:6|confirmed" : '';
        $distributorCompany = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $distributorDirector = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $distributorPhone = $request->input('role_id') == 3 ? 'required|min:6' : '';
        $distributorAddress = $request->input('role_id') == 3 ? 'required|string|min:2' : '';
        $request->validate([
            'distributor' => 'array',
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id."'"],
            'password' => $passwordRequired,
            'role_id' => ['required', 'integer'],
            'distributor.company' => $distributorCompany,
            'distributor.director' => $distributorDirector,
            'distributor.phone' => $distributorPhone,
            'distributor.address' => $distributorAddress,
        ]);

        $userData['name'] = $request->name;
        $userData['email'] = $request->email;
        $userData['role_id'] = $request->role_id;
        $userData['status'] = $request->status;
        if($request->password){
            $userData['password'] = Hash::make($request->input('password'));
        }
        $us = $user->update($userData);
        if($us){
            if ($request->role_id == User::DISTRIBUTOR) {
                $img = $request->file('distributor.logo');
                if ($img) {
                    $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'distributor'.DIRECTORY_SEPARATOR);
                    $imgName = UploadFile::upload($img,$path);

                    if(!$imgName) return response()->json(['message' => 'Something went wrong'],400);
                    $image = "/storage/distributor/".$imgName;

                    $distributorLogo = str_replace('/storage', '', $user->distributor->logo);
                    Storage::delete('/public' . $distributorLogo);

                    $data['logo'] = $image;
                }

                $data['company'] = $request->distributor['company'];
                $data['director'] = $request->distributor['director'];
                $data['address'] = $request->distributor['address'];
                $data['phone'] = $request->distributor['phone'];
                $data['tax_code'] = $request->distributor['tax_code'];
                $data['bank_name'] = $request->distributor['bank_name'];
                $data['iban'] = $request->distributor['iban'];
                $data['website'] = $request->distributor['website'];
                $data['description'] = $request->distributor['description'];


                $user->distributor()->update($data);
                return response()->json($user->fresh()->load('role','distributor'),200);
            }
            if($role && $user->role_id != User::DISTRIBUTOR){
                Distributor::where('user_id',$user->id)->delete();
            }
            return response()->json($user->fresh()->load(['role']),200);
        }
        return response()->json(['message' => 'Something went wrong'],400);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json($id,200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistributors(){
        return response()->json(User::whereHas('distributor')->with('distributor')->get());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistributor($id){
        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'User not found'],404);
        return response()->json($user->distributor()
            ->select(['id','company','director','description','tax_code','bank_name','iban','address','phone','website'])
            ->first(),200);
    }


    public function updateDistributor(Request $request,$id){
        $dist = Distributor::find($id);
        if(!$dist) return response()->json(['message' => 'Distributor not found'],404);
        if($dist->update($request->all())) return response()->json($dist->fresh(),200);;
        return response()->json(['message' => 'Something went wrong'],400);
    }
}
