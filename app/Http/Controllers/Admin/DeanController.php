<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Staff_DEAN;
use App\User;
use App\Designee;
use App\Staff;
use App\Http\Resources\Dean as DeanResource;
use App\Http\Resources\DeanCollection;
use App\UserRole;
class DeanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page =$request->per_page ? $request->per_page : 10; 
        $deans =  new DeanCollection(Staff_DEAN::with('user')->with('college')->with('semester')
        ->paginate($per_page));
        return response()->json([
            'deans' => $deans,
            'user_dean' => UserRole::orderBy('user_id')->with('user')->with('role')->whereHas('role',
            function ($q){
                $q->where('name','dean');
            }
            )->get(),
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
    public function show($id,Request $request)
    {
        $per_page =$request->per_page ? $request->per_page : 10;
        return response()->json([
            'deans' => new DeanCollection(
                Staff_DEAN::with('user')->with('semester')->with('college')
                ->whereHas('user', function($q) use ($id){
                    $q->where('name', 'ILIKE', '%' . $id . '%');
                })  
            ->orWhereHas('college', function($q) use ($id){
                $q->where('short_name', 'ILIKE', '%' . $id . '%')
                ->where('name', 'ILIKE', '%' . $id . '%');
            }) 
            ->orWhereHas('semester', function($q) use ($id){
                $q->where('semester', 'ILIKE', '%' . $id . '%');
            }) 
            ->paginate($per_page)),
            'user_dean' => UserRole::orderBy('user_id')->with('user')->with('role')->whereHas('role',
            function ($q){
                $q->where('name','dean');
            }  )->get(),
            ],200);
        //
    }
    public function changeDean(Request $request){
        $dean = Staff_DEAN::find($request->dean);
        $staff = $dean;
        
        $changeStaff =Staff::where('user_id',$staff->user_id)->where('semester_id',$staff->semester_id)
        ->where('designee_id',Designee::where('name','College Dean')->first()->id)->first();
        // dd($staff);
        $changeStaff->user_id =$request->new_dean; 
        $changeStaff->save(); 
        $dean->user_id=$request->new_dean; 
        $dean->save();
      
        $per_page =$request->per_page ? $request->per_page : 10; 
        $deans =  new DeanCollection(Staff_DEAN::with('user')->with('college')->with('semester')
        ->paginate($per_page));
        return response()->json([
            'deans' => $deans,
            'user_dean' => UserRole::orderBy('user_id')->with('user')->with('role')->whereHas('role',
            function ($q){
                $q->where('name','dean');
            }
            )->get(),
            ],200);

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
