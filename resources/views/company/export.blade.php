<x-modal id="company-export" title="Export" >
    <div class="row justify-content-center">
        <div>
            <form action="" >
                @include('forms.dynamic-input',['name'=>'start_date', 'title'=>'Start Date', 'value' => $record->start_date ?? '' , 'type' => 'date','required' =>true])

                @include('forms.dynamic-input',['name'=>'end_date', 'title'=>'End Date', 'value' => $record->end_date ?? '' , 'type' => 'date','required' =>true])

                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</x-modal>


