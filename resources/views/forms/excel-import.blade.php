<form class="form-group row mt-4" method="POST" action="{{$route}}" enctype="multipart/form-data">
    @csrf
    <div class="col-md-8 d-flex justify-content-end">
        <input class="form-control" name="import" type="file">
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary">Import</button>
    </div>
</form>
