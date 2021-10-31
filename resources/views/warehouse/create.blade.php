<div class="modal fade" id="stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">New Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="case_create" action="{{route("warehouses.store")}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Name</label><br>
                        <input type="text" id="name" class="form-control mb-3"  name="name" required>
                        @error('case_name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="from-group">
                        <label for="desc">Description</label>
                        <textarea name="description" id="desc" cols="30" class="form-control"  rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success float-right mr-2">Save</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
