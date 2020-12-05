<div>
    <div class="row justify-content-center">
        <div>
            <form action="{{route($route)}}" method="POST">
                @csrf
                <x-forms.basic.input name="start_date" type="date" value="" title="Start Date" required></x-forms.basic.input>
                <x-forms.basic.input name="end_date" type="date" value="" title="End Date" required></x-forms.basic.input>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>
