<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $validate= Validator::make($collection->toArray(), [
            '*.name' => 'required',
            '*.parent_id' => 'required',
        ]);
//       dd($validate);
        if($validate->fails()) {
            return redirect()->back()->with('import_error','Something column is missing or incorrect! Check your import file');
        }
        foreach ($collection as $item){

        }
    }
}
