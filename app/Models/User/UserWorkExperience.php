<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserWorkExperience extends Model
{
    protected $table='user_work_experiences';
    protected $fillable=['job_title','from_date','to_date','company','isPresent','user_id'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
