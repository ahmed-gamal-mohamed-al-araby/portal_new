<?php

namespace App\Imports;

use App\Models\BusinessNature;
use App\Models\Project;
use App\Models\Sector;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
class ProjectImport implements ToCollection, WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
    public function collection(Collection $rows)
    {

  
        foreach ($rows as $row) {
            if ($row['type'] == "شامل") {
                $row['type'] == "comprehensive";
            }
            elseif($row['type'] == "غير شامل"){
                $row['type'] == "Excl";
            }
            else{
                $row['type'] == "";
            }

            $row['business_nature_id']=BusinessNature::where("name_ar",$row['business_nature_id'])->first()->id;
            $row['sector_id']=Sector::where("name_en",$row['sector_id'])->first()->id;
            $project = Project::create([
                "name_ar" =>  $row['name_ar'],
                "name_en" =>  "",
                "code" =>  $row['code'],
                "type" =>  $row['type'],
                "business_nature_id" =>  $row['business_nature_id'],
                "description_ar" =>  $row['name_ar'],
                "description_en" =>  $row['name_ar'],
                "sector_id" =>   $row['sector_id'],
                "manager_id" =>  15,
                "delegated_id" =>  1,
                "group_id" =>  2,
                "completed" =>  0,


            ]);
        }
    }

}
