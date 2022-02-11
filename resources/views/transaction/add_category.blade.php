<div id="add_cat" class="modal custom-modal fade" data-backdrop="true" tabindex="-1" role="dialog" style="overflow:hidden">
    <div class="modal-dialog modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tags">Name</label>
                    <input type="text" id="name" class="form-control" name="tags" >
                </div>
                <button type="button" data-dismiss="modal" id="add_category"  class="btn btn-primary float-right">Add</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#add_category', function () {
            var name=$("#name").val();
            $.ajax({
                type:'POST',
                data : {name:name},
                url:'/add/category',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    console.log(data);
                    $("#cat_div").load(location.href + " #cat_div>* ");
                    $("#category").load(location.href + " #category>* ");
                    $("#add_cat").load(location.href + " #add_cat>* ");
                }
            });
        });
    });
</script>