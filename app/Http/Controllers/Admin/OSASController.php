<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Staff;
use App\User;
use App\Designee;
use App\Http\Resources\OSAS as OSASResource;
use App\Http\Resources\OSASCollection;
class OSASController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $per_page =$request->per_page ? $request->per_page : 10; 
            $osas =  new OSASCollection(Staff::where('designee_id',
            Designee::where('short_name','OSAS')->first()->id)->with('user')->with('semester')->with('designee')->with('campus')
            ->paginate($per_page));
            return response()->json([
                'osass' => $osas
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
            'osass' => new OSASCollection(
                Staff::where('designee_id',
                Designee::where('short_name','OSAS')->first()->id)->with('designee')
                ->with('user')->with('semester')->with('campus') 
            ->whereHas('campus', function($q) use ($id){
                $q->where('name', 'ILIKE', '%' . $id . '%');
            }) 
            ->orWhereHas('semester', function($q) use ($id){
                $q->where('semester', 'ILIKE', '%' . $id . '%');
            }) 
            ->paginate($per_page)),
            ],200);
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
