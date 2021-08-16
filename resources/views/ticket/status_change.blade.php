<div class="dropdown-menu dropdown-menu-right">
    @foreach($statuses as $key=>$val)

           @if($val!='Overdue')
            @foreach($status_color as $staus=>$color)
                @if($staus==$val)
                    <input type="hidden" id="status_id{{$key}}" value="{{$key}}">
                    <a class="dropdown-item" href="#" id="status_change{{$key}}" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$val}}</a>
                @endif
            @endforeach
            <script>
                $(document).ready(function() {
                    $(document).on('click', '#status_change{{$key}}', function () {

                        // var customer_id=$("#customer_id").val();
                        var status=$("#status_id{{$key}}").val();
                        $.ajax({
                            data : {
                                status_id:status,

                            },
                            type:'POST',
                            url:"{{url('status/'.$ticket->id)}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                $("#status_div").load(location.href + " #status_div>* ");

                            }
                        });
                    });
                });
            </script>
               @endif
    @endforeach
</div>