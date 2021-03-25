<?php

namespace App\Http\Resources\User\Profile;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class WorkExperience extends JsonResource
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
            'jobTitle' => $this->job_title, 
            'startDate' => Carbon::parse($this->from_date)->isoFormat('MMMM DD, YYYY'), 
            'endDate' => Carbon::parse($this->to_date)->isoFormat('MMMM DD, YYYY'), 
            'sDate' => $this->from_date,
            'eDate' => $this->to_date,
            'isPresent' => $this->isPresent,
            'companyName' => $this->company,
            'user_name' => $this->user->name,
        ];
    }
}
