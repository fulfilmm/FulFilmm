<div class="modal custom-modal fade" id="delete{{$meeting->id}}">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('meetings.destroy',$meeting->id)}}" method="POST">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <strong>Do you want to Delete Meeting {{$meeting->title}}?</strong>
                </div>
                <div class="modal-footer text-center">
                    <button type="button"class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success ">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
