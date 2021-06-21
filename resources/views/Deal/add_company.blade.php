<div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    @include('company.form')
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary" type="button" data-dismiss="modal" id="create_com">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>
