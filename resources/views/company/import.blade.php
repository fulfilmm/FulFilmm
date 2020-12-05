<x-partials.modal id="company-import" title="Import" >

    <div class="row justify-content-center">
        <div>
            @include('forms.excel-import', ['route' => route('customers.import')])
        </div>
    </div>
</x-partials.modal>
