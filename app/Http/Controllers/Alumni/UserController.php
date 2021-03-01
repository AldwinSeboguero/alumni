<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Batch;
use App\CollegeBatch;
use App\HighBatch;
use App\User;
use App\UserDetail;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        return response()->json([
            'batches' => Batch::orderBy('id')->get(),
            'h_years' => HighBatch::orderBy('id')->get(),
            'c_years' => CollegeBatch::orderBy('id')->get(),
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
        $user = new User([ 
            'fname' => $request->fname ,
            'mname' => $request->mname ,
            'lname' => $request->lname ,
            'email' => $request->email , 
            'password' => Hash::make($request->password) ,
            'status' => 0, 
        ]);  
        $user->save();
        $batch = new UserDetail([ 
            'student_number' => $request->student_number ,
            'batch_type_id' => $request->batch ,
            'h_batch_year_id' => $request->h_year ,
            'c_batch_year_id' => $request->c_year ,  
            'user_id' => $user->id,
        ]);  
        $role =Role::where('name','user')->first();
        $user->roles()->attach($role);
        $batch->save();
        Auth::login($user);
        return redirect('/')->withJson(['message'=> 'Successfully Register'],200);
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
