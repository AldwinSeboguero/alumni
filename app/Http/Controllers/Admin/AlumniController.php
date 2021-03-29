<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Alumni;
use App\Http\Resources\Admin\Alumni as AlumniResource;
use App\Http\Resources\Admin\AlumniCollection;
class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'alumni' => new AlumniCollection(Alumni::orderByDesc('updated_at')
            ->with('batchType')
        ->with('collegeBatch')
        ->with('highBatch')
            ->paginate(10)),
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
        $alumni = new Alumni([
            'student_number' => $request->student_number,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'address' => $request->address, 
            'batch_type_id' => $request->batch, 
            'h_batch_year_id' => $request->h_year,
            'c_batch_year_id' => $request->c_year, 
        ]);  
        $alumni->save();
        return response()->json([
            'alumni' => new AlumniCollection(Alumni::orderByDesc('updated_at')
            ->with('batchType')
        ->with('collegeBatch')
        ->with('highBatch')
            ->paginate(10)),
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        return response()->json([
        'alumni' => new AlumniCollection(Alumni::orderByDesc('updated_at')
        ->with('batchType')
        ->with('collegeBatch')
        ->with('highBatch')
        ->where('fname','ILIKE','%'.$id.'%')
        ->orWhere('mname','ILIKE','%'.$id.'%')
        ->orWhere('lname','ILIKE','%'.$id.'%')
        ->orWhereHas('collegeBatch', function($q) use ($id)
        {
            $q->where('year','ILIKE','%'.$id.'%');

        })
        ->orWhereHas('highBatch', function($q) use ($id)
        {
            $q->where('year','ILIKE','%'.$id.'%');

        })
        ->orWhereHas('batchType', function($q) use ($id)
        {
            $q->where('name','ILIKE','%'.$id.'%');

        })
        ->paginate(10)), 
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

    public function verifyStudentNumber(Request $request){
        $exist = Alumni::where('student_number', $request->student_number)->first();
        if (!$exist) {
            return response()->json(['message' => 'Valid Student Number'], 200);
        }
        else{
            return response()->json(['message' => 'Already Exist!'], 409);
        }
       
    }
    public function deleteAlumni(Request $request){
        $alumni = Alumni::find($request->alumni['id']);
        $deleted_alumni = $alumni;
        $alumni->delete(); 
        \LogActivity::addToLog('Delete Alumni Data. ( ID: '.$deleted_alumni->id.' NAME: '.$deleted_alumni->fname.' '.$deleted_alumni->lname.')');
        return response()->json([
            'alumni' => new AlumniCollection(Alumni::orderByDesc('updated_at')
            ->with('batchType')
        ->with('collegeBatch')
        ->with('highBatch')
            ->paginate(10)),
        ],200);
    }
    public function updateAlumni(Request $request)
    {
        $alumni = Alumni::find($request->id); 
        $alumni->student_number = $request->student_number;
        $alumni->fname = $request->fname;
        $alumni->mname = $request->mname;
        $alumni->lname = $request->lname;
        $alumni->address = $request->address; 
        $alumni->batch_type_id = $request->batch; 
        $alumni->h_batch_year_id = $request->h_batch_year_id;
        $alumni->c_batch_year_id = $request->c_batch_year_id; 
     
        $alumni->save();
        return response()->json([
            'alumni' => new AlumniCollection(Alumni::orderByDesc('updated_at')
            ->with('batchType')
        ->with('collegeBatch')
        ->with('highBatch')
            ->paginate(10)),
        ],200);
    }
}
