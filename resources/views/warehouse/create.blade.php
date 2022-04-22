<div class="modal fade" id="stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">Add New Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="case_create" action="{{route("warehouses.store")}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="id">Warehouse ID</label>
                                <input type="text" class="form-control" name="warehouse_id" value="{{$warehouse_id}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="name">Name</label><br>
                                <input type="text" id="name" class="form-control mb-3" name="name" required>
                                @error('case_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="branch">Office Branch</label>
                                <select name="branch_id" id="branch" class="form-control select2">
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="checkbox" class="mr-2" name="is_virtual" value="1"><label for="">Virtual
                                    Warehouse</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" class="mr-2" name="mobile_warehouse" id="ismobile" value="1"><label for="">Is Mobile
                                    Warehouse</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">

                            <div class="from-group mb-2">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" cols="30" class="form-control"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right mr-2">Save</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
     if($('#ismobile').is(':checked')){
         $('#main_warehouse_div').show();

     }else {
         $('#main_warehouse_div').hide();
     }
    });
    $('#ismobile').click(function () {
        if($('#ismobile').is(':checked')){
            $('#main_warehouse_div').show();

        }else {
            $('#main_warehouse_div').hide();
        }
    });

</script>
