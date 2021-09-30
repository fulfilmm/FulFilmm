<div class="modal custom-modal rounded" id="remove{{$order->id}}">
    <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remove Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('invoice_items.destroy',$order->id)}}" method="POST">
               @csrf
                @method('delete')
                <div class="col-12">
                    <span class="text-center">Do You Want to remove this item?</span>
                </div>
                <div class="form-group my-3 text-center">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
