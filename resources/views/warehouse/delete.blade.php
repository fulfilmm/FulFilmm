<div class="modal fade" id="delete{{$warehouse->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Stock</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete" action="{{route('warehouses.destroy',$warehouse->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="dept_name">Do You Want To Delete {{$warehouse->name}}? </label><br>
                    </div>
                    <button type="submit" class="btn btn-success float-right mr-2">Yes</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-dismiss="modal">No</button>

                </form>
            </div>
        </div>
    </div>
</div>
