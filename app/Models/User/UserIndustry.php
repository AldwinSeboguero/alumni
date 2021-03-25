<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserIndustry extends Model
{
    protected $table='user_industries';
    public function industry(){
        return $this->belongsTo('App\Models\Industry','industry_id');
    }
}
