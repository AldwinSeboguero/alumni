<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Student;
use App\Role;
use Laravel\Socialite\Facades\Socialite; 
use Exception;
class LoginController extends Controller
{
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if(!Auth::attempt($login)){
            return response(['message'=> 'Incorrect email or password!'],403);
        }

        $accessToken =Auth::user()->createToken('authToken')->accessToken;    
        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }
    public function register(Request $request){
       
        if ($request->password == $request->rpassword) {
               $student= Student::find($request->student);
                $user = User::create([
                    'name' => $student->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'username' => $request->email,
                ]);
                // $user['name'] = $data->name;
                // $user['email'] =$data->email;
                // $user['password'] = Hash::make($data->password);
                // $user['username'] = $data->username;
                // User::insert($user);
                $role =Role::where('name','student')->first();
                $user->roles()->attach($role);
                $student->is_activated = true;
                $student->user_id = $user->id;
                $student->update();
                return response(['message' => 'Please try your newly registered account!'],200);
        }
        else{
            return response(['message' => 'Mismatch Password!']);
        }
    }
    public function handleGoogleCallback()
    {
        try {
            //create a user using socialite driver google
            $user = Socialite::driver('google')->stateless()->user(); 
            // if the user exits, use that user and login
            dd($user);
            // $finduser = User::where('google_id', $user->id)->first();
            $finduser = User::where('email', $user->email)->first();
            
            if($finduser){
                //if the user exists, login and show dashboard
                Auth::login($finduser);
                return redirect('/');
            }else{
                //user is not yet created, so create first
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('')
                ]);
                //every user needs a team for dashboard/jetstream to work.
                //create a personal team for the user
                $newTeam = Team::forceCreate([
                    'user_id' => $newUser->id,
                    'name' => explode(' ', $user->name, 2)[0]."'s Team",
                    'personal_team' => true,
                ]);
                // save the team and add the team to the user.
                $newTeam->save();
                $newUser->current_team_id = $newTeam->id;
                $newUser->save();
                //login as the new user
                Auth::login($newUser);
                // go to the dashboard
                return redirect('/');
            }
            //catch exceptions
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();

    }
}

