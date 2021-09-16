<div class="dropdown-menu dropdown-menu-right">
    @if($ticket->isassign==0)
    @foreach($priorities as $priority)
                    <input type="hidden" id="priority_{{$priority->id}}" value="{{$priority->id}}">
            <a class="dropdown-item" href="#" id="priority{{$priority->id}}"><i class="fa fa-dot-circle-o mr-1 text-{{$priority->color}}"></i>{{$priority->priority}}</a>
                    {{--<a class="dropdown-item" href="#" id="submit{{$priority->id}}" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1 text-{{$priority->color}}"></i>{{$priority->priority}}</a>--}}
            <script>
                $(document).ready(function() {
                    $(document).on('click', '#priority{{$priority->id}}', function () {

                        var pid=$("#priority_{{$priority->id}}").val();
                        $.ajax({
                            data : {
                                priority_id:pid

                            },
                            type:'POST',
                            url:"{{url('priority/change/'.$ticket->id)}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                $("#priority_div").load(location.href + " #priority_div>* ");

                            }
                        });
                    });
                });
            </script>
    @endforeach
    @else
        <a class="dropdown-item" href="#"  data-toggle="dropdown" aria-expanded="false"><i class="fa fa-exclamation-circle mr-1 text-warning"></i>This ticket has been assigned.You Cann't Change Priority!</a>
    @endif
</div>