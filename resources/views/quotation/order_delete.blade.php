<div class="modal fade" id="delete{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('orders.destroy',$order->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="text-center">
                                                <span>
                                                    Are you sure cancel this order?
                                              </span>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-primary">Cancel</button>
                    <button type="submit" class="btn btn-danger  my-2">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>