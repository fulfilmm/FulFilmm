@extends('layout.mainlayout')

@section('name', 'Contact')

@section('content')

    <!-- Page Header -->
    <div class="content container-fluid">
        @include('layout.partials.page-header', ['route' => 'customers','name'=>'Contact', 'import' => true, 'export' => true, 'card' => true, 'list' => true])
        @yield('data')
    </div>
    <script>
        $(document).ready(function() {
            $('#action').hide();
            $('input[type="checkbox"]').click(function () {
                $('input[type="checkbox"]').click(function () {
                    var checked_id = new Array();
                    $("input:checked").each(function () {
                        // console.log($(this).val()); //works fine
                        checked_id.push($(this).val());
                    });
                    if (checked_id.length > 0) {
                        $('#action').show();
                    } else {
                        $('#action').hide();
                    }

                });
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#type_change', function () {
                var checked_id = new Array();
                $("input:checked").each(function () {
                    // console.log($(this).val()); //works fine
                    checked_id.push($(this).val());
                });
                var action_type=$( "#type option:selected" ).val();
                // alert(action_type);
                $.ajax({
                    type:'POST',
                    data : {action_Type:action_type,customer_id:checked_id},
                    url:'change/contact/type',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection


