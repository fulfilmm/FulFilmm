<form method="POST" action="{{$route}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="">
            <input
            id="excel-import"
            name="import"name="import"
            type="file"
            value="" required
            autocomplete="name"
            class="form-control">
        </div>
        @error('name')
        <br>
        <span class="" role="alert">
            <p class="text-danger">{{ $message }}</p>
        </span>
        @enderror
    </div>
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary">Import</button>
    </div>
</form>
