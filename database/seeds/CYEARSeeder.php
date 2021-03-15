<?php

use Illuminate\Database\Seeder;
use App\CollegeBatch;
class CYEARSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/c_year.json");
        $data = json_decode($file);
        foreach ($data as $key => $obj) {
            # code...
            CollegeBatch::create(array(
                'year' => $obj->year, 
            ));
           
        }
    }
}
