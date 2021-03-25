<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table='user_contacts';
    protected $fillable=['work','home','address','user_id'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
