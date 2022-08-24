<div id="delete_check{{$item->id}}"
     class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('todo_checklists.destroy',$item->id)}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="col-12 text-center">
                        <h4> Are you sure ?</h4>
                        <div class="form-group mt-5">
                            <button type="submit"
                                    class="btn btn-info">
                                Yes
                            </button>
                            <button type="button" data-dimiss="modal"
                                    class="btn btn-info">
                                No
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '#complete{{$item->id}}', function () {
// alert('hello');
            var done = $('#complete{{$item->id}}').val();
            $.ajax({
                type: 'PUT',
                data: {
                    done: done,

                },
                url: "{{route('todo_checklists.update',$item->id)}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                },

            });
        });
        $(document).on('click', '#not_complete{{$item->id}}', function () {
// alert('hello');
            var done = $('#not_complete{{$item->id}}').val();
            $.ajax({
                type: 'PUT',
                data: {
                    done: done,

                },
                url: "{{route('todo_checklists.update',$item->id)}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                },

            });
        });
        $(document).on('click', '#remark{{$item->id}}', function () {
// alert('hello');
            $.ajax({
                type: 'PUT',
                data: {
                    remark: 1,

                },
                url: "{{route('todo_checklists.update',$item->id)}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                },

            });
        });
        $(document).on('click', '#cancel_remark{{$item->id}}', function () {
// alert('hello');
            $.ajax({
                type: 'PUT',
                data: {
                    remark: 0,

                },
                url: "{{route('todo_checklists.update',$item->id)}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                },

            });
        });
    });
</script>