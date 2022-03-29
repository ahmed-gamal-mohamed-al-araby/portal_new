<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\FamilyNameSupplier;
use App\Models\PersonSupplier;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
class SupplierImport implements ToCollection, WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
    public function collection(Collection $rows)
    {
     
  
        foreach ($rows as $row) {
            $address = Address::create([
                "country_id" => 64,
                // "governorate_id" => 2,

            ]);
            $supplier= Supplier::create([
                'name_en'    => $row['name_en'],
                'tax_id_number'    => $row['tax_id_number'],
                'address_id' => $address->id,

            ]);

            PersonSupplier::create([
                'mobile' => "",
                'supplier_id' => $supplier->id,
            ]);
            FamilyNameSupplier::create([
                'supplier_id' => $supplier->id,
                'family_name_id' => 1,
            ]);
        }
    }

}
