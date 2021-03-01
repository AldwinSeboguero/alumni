<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HighBatch extends Model
{
    protected $table='h_batch_years';
    protected $fillable=['year'];
}
