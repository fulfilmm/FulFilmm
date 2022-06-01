<?php

namespace App\Imports;

use App\Models\HeadOffice;
use App\Models\OfficeBranch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BranchImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $validate= Validator::make($collection->toArray(), [
            '*.name' => 'required',
            '*.head_office' => 'required',
        ]);
//       dd($validate);
        if($validate->fails()) {
            return redirect()->back()->with('import_error','Something column is missing or incorrect! Check your import file');
        }else{
            foreach ($collection as $item){
                $head=HeadOffice::where('name',$item['head_office'])->first();
               if($head!=null){
                   $data['head_office']=$head->id;
                   $data['name']=$item['name'];
                   $data['address']=$item['address']??'';
                   $data['type']="Branch";
                   OfficeBranch::create($data);
               }else{
                   return redirect()->back()->with('import_error','Head office name is incorrect! Check your import file');
               }
            }
        }
    }
}
