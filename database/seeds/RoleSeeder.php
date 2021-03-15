<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::truncate();

        // Role::create(['name'=>'admin','description'=>'Administrator']);
        // Role::create(['name'=>'user','description'=>'User']);
        // Role::create(['name'=>'director','description'=>'Alumni Director']);
        $roles = File::get("database/data/role.json");
        $data = json_decode($roles);
        foreach ($data as $key => $obj) {
            # code...
            Role::create(array(
                'name' => $obj->name,
                'description'=> $obj->description,
            ));
           
        }
        
    
    }
}
