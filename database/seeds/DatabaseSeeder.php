<?php

use App\Purpose;
use Illuminate\Database\Seeder;  
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class, 
            BatchSeeder::class, 
            CYEARSeeder::class, 
            HYEARSeeder::class, 
            IndustrySeeder::class, 
            SkillSeeder::class, 
        ]);
    }
}
