<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class Alumni extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'student_number' => $this->student_number,
            'name' => $this->fname.' '.$this->lname, 
            'address' => $this->address, 
            'batch_type' => $this->batchType->name,
            'c_year' => $this->collegeBatch ? $this->collegeBatch->year : '',
            'h_year' => $this->highBatch ? $this->highBatch->year : '',
            'year' => $this->batchType->name != 'Both College and High School' ? 
            $this->collegeBatch ? $this->collegeBatch->year 
            : ($this->highBatch ? $this->highBatch->year : '' )
            : $this->collegeBatch->year.' & '.$this->highBatch->year,
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname, 
            'batch' => $this->batchType->id,
            'h_batch_year_id' => $this->highBatch ? $this->highBatch->id : '',
            'c_batch_year_id' => $this->collegeBatch ? $this->collegeBatch->id : '', 

        ];
    }
}
