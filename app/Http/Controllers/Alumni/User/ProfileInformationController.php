<?php

namespace App\Http\Controllers\Alumni\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\UserIndustry;
use App\Models\Industry;
use App\Models\User\UserSkill;
use App\Models\User\UserContact;
use App\Models\User\UserWorkExperience;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\Profile\WorkExperienceCollection;
class ProfileInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'user_industries' => UserIndustry::orderBy('id')->with('industry')->where('user_id', Auth::user()->id)->get(),
            'user_skills' => UserSkill::orderBy('id')->where('user_id', Auth::user()->id)->get(),
            'user_contact' => UserContact::orderBy('id')->where('user_id', Auth::user()->id)->latest()->first(),
            'user_work_experience' => new WorkExperienceCollection(UserWorkExperience::orderBy('from_date','desc')->orderBy('created_at','desc')->where('user_id', Auth::user()->id)->paginate(5)),
            'all_industry' => Industry::orderBy('id')->get(),
        ],200);
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
}
