<script>
    $(document).ready(function () {
        $('#type{{$minute->id}}').select2();
        // $('#assign_to').select2();
    });
    $(document).ready(function () {
        // $('#type').select2();
        $('#assign_to{{$minute->id}}').select2();
    });
    $(document).ready(function () {
        $("#type{{$minute->id}}").change(function () {
            var val = $(this).val();
            if (val == "dept") {
                $("#assign_to{{$minute->id}}").html("@foreach($depts as $dept)<option value='{{$dept->id}}'>{{$dept->name}}</option> @endforeach");
            } else if (val == "emp") {
                $("#assign_to{{$minute->id}}").html("@foreach($all_emp as $emp)<option value='{{$emp->id}}'>{{$emp->name}}</option> @endforeach");
            }else if (val == "group") {
                $("#assign_to{{$minute->id}}").html("<option>Group Name</option>")
            }else {
                $("#assign_to{{$minute->id}}").html("<option></option>")
            }
        });
    });
    $(document).ready(function() {
        $(document).on('click', "#submit{{$minute->id}}", function () {
            var type=$('#type{{$minute->id}} option:selected').val();
            var assign_to=$('#assign_to{{$minute->id}} option:selected').val();
            var minutes_id=$('#minutes_id{{$minute->id}}').val();
            var due_date=$('#due_date{{$minute->id}}').val();
            $.ajax({
                type:'POST',
                data : {
                    assing_type:type,
                    assign_to:assign_to,
                    minute_id:minutes_id,
                    due_date:due_date
                },
                url:"{{route('assign.minutes')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if($.isEmptyObject(data.error)){
                        console.log(data);
                        $("#minutelist{{$minute->id}}").load(location.href + " #minutelist{{$minute->id}}>* ");
                        $("#view{{$minute->id}}").load(location.href + " #view{{$minute->id}}>* ");
                        alert(data.Success);
                    }else {
                        $.each(data.error,function (key,value){
                            console.log(key);
                            $('.'+key+'_err').text(value);
                        });
                    }
                }
            });
        });
    });
    $(document).ready(function() {
        $(document).on('click', "#complete_todo{{$minute->id}}", function () {
            var minutes_id=$('#minutes_id{{$minute->id}}').val()
            $.ajax({
                type:'POST',
                data : {
                    minute_id:minutes_id,
                },
                url:"{{route('complete.minutes')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    console.log(data);
                    if($.isEmptyObject(data.error_msg)) {
                        $("#minutelist{{$minute->id}}").load(location.href + " #minutelist{{$minute->id}}>* ");
                        $("#view{{$minute->id}}").load(location.href + " #view{{$minute->id}}>* ");
                    }else {
                        alert(data.error_msg);
                    }
                }
            });
        });
    });
</script>