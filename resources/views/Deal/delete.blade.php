<div class="modal custom-modal fade" id="delete_deal{{$deal->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Deal "{{$deal->name}}"</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{route('deals.destroy',$deal->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="row text-center">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn col-12">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
