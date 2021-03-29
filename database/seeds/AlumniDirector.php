<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class AlumniDirector extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminrole = Role::where('name','director')->first(); 
        $pd = User::create([
            'fname' => 'Margarita',
            'mname' => '',
            'lname' => 'Lanciso',
            'email' => 'alumni@parsu.edu.ph',
            'bday' => '03/29/2021',
            'password' => Hash::make('parsu2021') ,
            'status' => 1, 
                 
        ])->roles()->attach($adminrole);
    }
}
