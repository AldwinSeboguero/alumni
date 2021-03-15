<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Batch;
use App\CollegeBatch;
use App\HighBatch; 
use App\UserDetail;
use App\Role; 

use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],  
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'fname' => $data['fname'],
        //     'lname' => $data['lname'],
        //     'mname' => $data['mname'],
        //     'bday' => $data['bday'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]); 
        $user = new User([ 
            'fname' => $data["fname"] ,
            'mname' => $data["mname"] ,
            'lname' => $data["lname"] ,
            'email' => $data["email"] ,  
            'bday' => $data['bday'],
            'password' => Hash::make($data["password"]) ,
            'status' => 0, 
        ]);  
        $user->save();
        $batch = new UserDetail([ 
            'student_number' => $data["student_number"] ,
            'batch_type_id' => $data["batch"] ,
            'h_batch_year_id' => $data["h_year"] ,
            'c_batch_year_id' => $data["c_year"] ,  
            'user_id' => $user->id,
        ]);  
        $role =Role::where('name','user')->first();
        $user->roles()->attach($role);
        $batch->save(); 
        return $user;
    }
}
