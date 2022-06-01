<?php

namespace App\Imports;

use App\Models\OfficeBranch;
use App\Models\Region;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $validate= Validator::make($collection->toArray(), [
            '*.name' => 'required',
            '*.branch' => 'required',
        ]);
//       dd($validate);
        if($validate->fails()) {
            return redirect()->back()->with('import_error','Something column is missing or incorrect! Check your import file');
        }else{
            foreach ($collection as $item){
                $branch=OfficeBranch::where('name',$item['branch'])->first();
                if($branch!=null){
                    $data['name']=$item['name'];
                    $data['branch_id']=$branch->id;
                    Region::create($data);
                }else{
                    return redirect()->back()->with('import_error','Branch name'.$item['branch'].' is incorrect! Check your import file');
                }
            }
        }
    }
}
