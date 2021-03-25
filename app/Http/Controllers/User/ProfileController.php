<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\User\UserWorkExperience;
use App\Models\User\UserContact;
use App\Http\Resources\User\Profile\WorkExperienceCollection;
class ProfileController extends Controller
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
    public function upload(Request $request){
      
        // dd($p);
        // $path = $request->file('image')->store('public/images');
        // return response()->json(['url'=>'/storage/'.$path]);
        $user = User::find(Auth::user()->id);
        
        if ($request->image) {
            $photo = $request->image; 
            $image = time().'.'.explode('/',explode(':',substr($photo,0,strpos($photo,';')))[1])[1]; 
            $path = '/storage/public/images/'.$image;
            $p = \Image::make($photo)->save(public_path($path));
            $user->photo = $path; 
        }
        
        $user->fname = $request->user["fname"];
        $user->mname = $request->user["mname"];
        $user->lname = $request->user["lname"];
        $user->email = $request->user["email"];
        $user->save();        
        return $user;
    }

    public function saveContactInformation(Request $request){ 
        if(!UserContact::where('user_id',Auth::user()->id)->first()){
        $contactInformation = new UserContact([
            'work' => $request->contact_work,
            'home' => $request->contact_home, 
            'address' => 'address', 
            'user_id' => Auth::user()->id,
        ]); 
        $contactInformation->save();
        }
        else{
            $contactInformation = UserContact::where('user_id',Auth::user()->id)->first();
            $contactInformation->work = $request->contact_work;
            $contactInformation->home = $request->contact_home;
            $contactInformation->address = 'address';
            $contactInformation->save();
        }
        return response()->json([ 
            'user_contact' => UserContact::orderBy('id')->where('user_id', Auth::user()->id)->latest()->first(), 
        ],200);
    }
    
    public function saveWorkExperience(Request $request){
        $workExperience = new UserWorkExperience([
            'job_title' => $request->experience['jobTitle'],
            'from_date' => $request->experience['startDate'],
            'to_date' => $request->experience['isPresent'] ? null : $request->experience['endDate'],
            'company' => $request->experience['companyName'],
            'isPresent' => $request->experience['isPresent'] ? $request->experience['isPresent'] : 0,
            'user_id' => Auth::user()->id,
        ]); 
        $workExperience->save();
        return response()->json([ 
            'user_work_experience' => new WorkExperienceCollection(UserWorkExperience::orderBy('from_date','desc')->orderBy('created_at','desc')->where('user_id', Auth::user()->id)->paginate(5)),
        ],200);
    }
    public function updateWorkExperience(Request $request){
        $workExperience = UserWorkExperience::find($request->experience['id']);
        
            $workExperience->job_title = $request->experience['jobTitle'];
            $workExperience->from_date = $request->experience['startDate'];
            $workExperience->to_date = $request->experience['isPresent'] ? null : $request->experience['endDate'];
            $workExperience->company = $request->experience['companyName'];
            $workExperience->isPresent = $request->experience['isPresent'] ? $request->experience['isPresent'] : 0;
          
        $workExperience->save();
        return response()->json([ 
            'user_work_experience' => new WorkExperienceCollection(UserWorkExperience::orderBy('from_date','desc')->orderBy('created_at','desc')->where('user_id', Auth::user()->id)->paginate(5)),
        ],200);
    }

    public function deleteWorkExperience(Request $request){
        $workExperience = UserWorkExperience::find($request->experience['id'])->delete(); 
        return response()->json([ 
            'user_work_experience' => new WorkExperienceCollection(UserWorkExperience::orderBy('from_date','desc')->orderBy('created_at','desc')->where('user_id', Auth::user()->id)->paginate(5)),
        ],200);
    }

    public function deleteImage(Request $request){
        $path = $request->image;
        $slice = Str::after($path,'/storage/');
        if (Storage::disk()->has($slice)) {
            Storage::delete($slice);
            # code...   
        }
    }
}
