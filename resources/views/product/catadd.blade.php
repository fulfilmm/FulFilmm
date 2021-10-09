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
                <div class="form-group ">
                    <label>Category Name</label>
                    <input type="text" id="cat_name" class="form-control" name="cat_name" >
                </div>
                <button   id="cat_create" data-dismiss="modal" class="btn btn-primary float-right">Add</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#cat_create', function () {
            var name=$("#cat_name").val();
            $.ajax({
                type:'POST',
                data : {name:name},
                url:'/cat/create',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    console.log(data);
                    $("#cat_div").load(location.href + " #cat_div>* ");
                    $("#cat_add").load(location.href + " #cat_add>* ");
                    $("#category").load(location.href + " #category>* ");
                }
            });
        });
    });

</script>