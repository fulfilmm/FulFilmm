
<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
    <div class="profile-widget">
        <div class="profile-img">
            <a href="{{route( $route.'.show', $id)}}" class="avatar text-center">
                <img src="{{$image ??''}}" alt="Add profile" data-toggle="tooltip" title="Profile" width="80px" height="80px" style="font-size: 8px;">
            </a>
        </div>
        <div class="dropdown profile-action">
            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" title="Action"
               aria-expanded="false" ><i class="material-icons">more_vert</i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" data-toggle="tooltip" title="Edit" href="{{route($route.'.edit',$id)}}"><i
                        class="fa fa-pencil m-r-5"></i> Edit</a>
                <form action="{{route($route.'.destroy',$id)}}"
                      id="del-{{$id}}" method="POST">
                    @method('delete')
                    @csrf
                    <a class="dropdown-item" href="#" data-toggle="tooltip" title="Delete" onclick="deleteRecord({{$id}})"><i
                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                </form>

            </div>
        </div>
        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile" data-toggle="tooltip" title="Name">{{$title}}</a></h4>
        <div class="small text-muted" data-toggle="tooltip" title="Email">{{$subtitle}}</div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteRecord(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You cannot retrieve data back!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff9b44',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                console.log(id)
                if (result.isConfirmed) {
                    console.log(id)
                    Swal.fire(
                        'Deleted!',
                        'Record has been deleted.',
                        'success'
                    ).then(() => {
                        document.getElementById("del-" + id).submit();
                    })

                }
            })
        }
    </script>
@endpush
