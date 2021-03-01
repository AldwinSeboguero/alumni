<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table='user_details';
    protected $fillable = [
        'batch_type_id',
        'student_number',
        'h_batch_year_id',
        'c_batch_year_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
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
