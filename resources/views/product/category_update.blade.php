<div id="cat_update{{$cat->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('product/category/update/'.$cat->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group ">
                        <label>Category Name</label>
                        <input type="file" id="icon" class="form-control" name="image" >
                    </div>
                    <div class="form-group ">
                        <label>Category Name</label>
                        <input type="text" id="cat_name" class="form-control" name="cat_name" value="{{$cat->name}}" >
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>