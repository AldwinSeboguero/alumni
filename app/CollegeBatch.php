<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollegeBatch extends Model
{
    protected $table='c_batch_years';
    protected $fillable=['year'];
}
