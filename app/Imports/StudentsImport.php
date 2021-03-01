<?php

namespace App\Imports;
use App\Student;
use App\Section;
use Maatwebsite\Excel\Concerns\ToModel;  
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Program;
use App\ProgramStudent;
use App\Campus;
use Illuminate\Support\Str;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = Student::updateOrCreate([
            'student_number'    => $row['student_number'],
            'slug'    => $row['student_number'].'-'.str_replace(".","",str_replace(",","",str_replace(" ","", $row['name']))),
            'name'    => $row['name'],
            'year'    => $row['year'],
            'section_id'     => 1, 
            'program_id'     => Program::where('name',$row['program'])->where('campus_id',Campus::where('name',$row['campus'])->first()->id)->first()->id, 
            'initial_password' => Str::uuid()->toString(),
             

        ]);
       
        return $student;
    }
}
