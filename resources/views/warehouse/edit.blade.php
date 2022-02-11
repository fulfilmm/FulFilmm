<div class="modal fade" id="stock{{$warehouse->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Warehouse</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="case_create" action="{{route('warehouses.update',$warehouse->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dept_name">Warehouse Name:</label><br>
                        <input type="text" id="dept_name" class="form-control mb-3"  name="name" value="{{$warehouse->name}}">
                    </div>
                    <input type="checkbox" class="mr-2" name="is_virtual" value="1"><label for="">Virtual Warehouse</label>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{$warehouse->address}}">
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="description" id="desc" cols="30" rows="10" class="form-control">{{$warehouse->description}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success float-right mr-2">Save</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
