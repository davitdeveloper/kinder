<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BadHabit;
use App\Models\Skill;
use App\Models\ChildrenAge;
use App\Models\ChildrenAmount;
use App\Models\Cities;
use App\Models\OwnLanguage;
use App\Models\User;
use App\Models\WorkType;
use Illuminate\Http\Request;

class BabySitterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function getInfoForCv($id){
        $cv = null;
        $babySitter = User::findOrFail($id)->babySitter;
        if($babySitter){
            $cv = $babySitter->load([
                'experiences',
                'educations',
                'workTypes',
                'childrenAges',
                'childrenAmounts',
                'ownLanguages',
                'badHabits',
                'skills',
                'regions'
            ]);
        }
        return response()->json([
            'work_types' => WorkType::all(),
            'children_ages' => ChildrenAge::all(),
            'children_amounts' => ChildrenAmount::all(),
            'own_languages' => OwnLanguage::all(),
            'bad_habits' => BadHabit::all(),
            'regions' => Cities::where('region_id',10)->get(),
            'skills' => Skill::all(),
            'cv' => $cv,
        ],200);
    }

    public function createCv(Request $request){
        return response()->json($request->all(),200);
        $request->validate([
            "resume.full_name" => "required|min:6",
            "resume.birthday" => "required",
            "resume.address" => "required",
            "resume.phone" => "required",
            "resume.family_status" => "required|min:10",
            "resume.personal_qualities" => "required|min:10",
            "resume.avatar_index" => "required",
            'images' => "required|array",
            'images.*' => "required|image|mimes:jpeg,jpg,png",
            'grafiks' => "required|array",
            'grafiks.*' => "required|array",
            'experiences' => "required|array",
            'experiences.*' => "required|array",
            'experiences.*.start' => "required",
            'experiences.*.end' => "required",
            'experiences.*.description' => "required",
            'educations' => "required|array",
            'educations.*' => "required|array",
            'educations.*.start' => "required",
            'educations.*.end' => "required",
            'educations.*.institution_name' => "required",
            'selectedWorkTypes' => "required|array",
            'selectedChildrenAges' => "required|array",
            'selectedChildrenAmounts' => "required|array",
            'selectedOwnLanguages' => "required|array",
            'selectedBadHabits' => "required|array",
            'selectedRegions' => "required|array",
            'selectedSkills' => "required|array",
        ]);
        dd($request->all());
    }
}
