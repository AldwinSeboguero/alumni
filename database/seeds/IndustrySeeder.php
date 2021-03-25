<?php

use Illuminate\Database\Seeder;
use App\Models\Industry;
class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/industry.json");
        $data = json_decode($file);
        foreach ($data as $key => $obj) {
            # code...
            Industry::create(array(
                'name' => $obj->occupations, 
            ));
           
        }
    }
}
