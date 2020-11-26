@include('forms.dynamic-input',['name'=>'name', 'title'=>'Name', 'value' => $record->name ?? ''])
@include('forms.select',['name'=>'parent_department', 'title'=>'Parent Department', 'placeHolder' => "Choose Parent Department", 'options' => $parent_departments, 'value' => $record->parent_department ?? ''])
@include('forms.textarea', ['name' => 'address', 'title' => 'Address', 'value' => $record->address ?? '', 'required' => false])
