<?php

namespace App\Imports;

use App\Models\products_category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductCategoryImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
//        $this->validate($collection,['parent_id']);
//        dd($collection);
       $validate= Validator::make($collection->toArray(), [
            '*.name' => 'required',
        ]);
//       dd($validate);
        if($validate->fails()) {
            return redirect()->back()->with('import_error','Something column is missing or incorrect! Check your import file');
        }
        foreach ($collection as $category){
            $parent=products_category::where('name',$category['parent_id'])->first();
            if($parent!=null){
                $data['parent_id']=$parent->id;
                $data['parent']=1;
            }else{
                $data['parent']=0;
            }
            $data['name']=$category['name'];
            products_category::create($data);
        }
    }
}
