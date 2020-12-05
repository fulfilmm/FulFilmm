<x-modal id="company-import" title="Import" >
<div class="row justify-content-center">
    <div>
        <div>
            <form action="">
                @include('forms.excel-import', ['route' => route('customers.import')])
            </form>
        </div>
    </div>
</div>
</x-modal>
