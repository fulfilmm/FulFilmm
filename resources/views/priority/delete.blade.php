<div class="modal fade" id="delete{{$priority->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Priority</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form   method="POST" action="{{route('priorities.destroy',$priority->id)}}" class="my-2">
                    @csrf
                    @method('DELETE')
                    Are You Sure delete priority name "{{$priority->priority}}"?
                    <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary float-right">No</button><button type="submit" class="btn btn-primary float-right">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
