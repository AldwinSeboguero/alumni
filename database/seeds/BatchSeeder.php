<?php

use Illuminate\Database\Seeder;
use App\Batch;
class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/batch_type.json");
        $data = json_decode($file);
        foreach ($data as $key => $obj) {
            # code...
            Batch::create(array(
                'name' => $obj->name, 
            ));
           
        }
    }
}
