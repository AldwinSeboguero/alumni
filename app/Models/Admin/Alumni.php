<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table='alumni';
    protected $fillable = [
        'student_number',
        'fname',
        'mname',
        'lname',
        'address', 
        'batch_type_id', 
        'h_batch_year_id',
        'c_batch_year_id', 
    ]; 
    public function batchType()
    {
        return $this->belongsTo('App\Batch','batch_type_id');
    }
    public function highBatch()
    {
        return $this->belongsTo('App\HighBatch','h_batch_year_id');
    }
    public function collegeBatch()
    {
        return $this->belongsTo('App\CollegeBatch','c_batch_year_id');
    }
}
