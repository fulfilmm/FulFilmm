<div id="add" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Tax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tax Name</label>
                    <input type="text" id="p_tax" class="form-control" name="tax" >
                </div>
                <label>Tax Rate</label>
                <div class="input-group">

                    <input type="number" id="rate" class="form-control" name="rate">
                    <button type="button" class="btn btn-white">%</button>
                </div>
            </div>
            <div class="form-group text-center">
                <button  id="tax_create" data-dismiss="modal" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#tax_create', function () {
            var name=$("#p_tax").val();
            var rate=$("#rate").val();
            $.ajax({
                type:'POST',
                data : {name:name,p_rate:rate},
                url:'/tax/create',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    console.log(data);
                    $("#tax_div").load(location.href + " #tax_div>* ");
                    $("#tax").load(location.href + " #tax>* ");
                    $("#add").load(location.href + " #add>* ");
                }
            });
        });
    });
</script>