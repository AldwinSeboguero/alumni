<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table='batch_types';
    protected $fillable=['name'];
}
