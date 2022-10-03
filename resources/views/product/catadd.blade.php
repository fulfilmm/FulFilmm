<div id="cat_add" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/cat/create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="form-group ">
                    <label>Category Icon</label>
                    <input type="file" id="caticon" class="form-control" name="image" required>
                </div>
                <div class="form-group ">
                    <label>Category Name</label>
                    <input type="text" id="cat_name" class="form-control" name="name" >
                </div>
                <input type="checkbox" name="parent" id="isparent" value="1"><span class="ml-2">Parent</span>
                <div class="form-group mt-2" id="parent">
                    <label for="parent_id">Parent Category</label>
                   <div class="input-group">
                       <select name="parent_id" id="parent_id" class="form-control" style="width: 100%">
                           @foreach($category as $cat)
                               <option value="{{$cat->id}}">{{$cat->name}}</option>
                           @endforeach
                       </select>
                   </div>
                </div>
                <button  type="submit"  id="cat_create"  class="btn btn-primary float-right">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).on('click','#isparent',function () {
            var parent=$('#isparent:checked').val();
            if(parent==1){
                $('#parent').hide();
            }else {
                $('#parent').show();
            }
        });

</script>