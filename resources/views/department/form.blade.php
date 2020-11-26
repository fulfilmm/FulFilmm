@include('forms.dynamic-input',['name'=>'name', 'title'=>'Name', 'value' => $record->name ?? '', 'required' =>true])
@include('forms.select',['name'=>'parent_department', 'title'=>'Parent Department', 'placeHolder' => "Choose Parent Department", 'options' => $parent_departments, 'value' => $record->parent_department ?? '', 'required' =>true])
@include('forms.textarea', ['name' => 'address', 'title' => 'Address', 'value' => $record->address ?? ''])
