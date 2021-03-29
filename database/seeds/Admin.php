<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminrole = Role::where('name','admin')->first();
        
   
      

        $pd = User::create([
            'fname' => 'Aldwin',
            'mname' => 'Ricafort',
            'lname' => 'Seboguero',
            'email' => 'aldwin.seboguero@parsu.edu.ph',
            'bday' => '08/09/1996',
            'password' => Hash::make('ICTMOPa55') ,
            'status' => 1, 
                 
        ])->roles()->attach($adminrole);
    }
}
