<?php

use Illuminate\Database\Seeder;
use App\HighBatch;
class HYEARSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/h_year.json");
        $data = json_decode($file);
        foreach ($data as $key => $obj) {
            # code...
            HighBatch::create(array(
                'year' => $obj->year, 
            ));
           
        }
    }
}
