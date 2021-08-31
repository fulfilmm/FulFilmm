@extends('layout.mainlayout')
@section('title','')
@section('content')
    <div class="container-fluid">
        <form action="{{url('oauth/clients')}}" method="POST">
            @csrf
            <input type="text" name="name">
            <input type="text" name="url">
    <button type="submit">Submit</button>
        </form>
        <label for="startDate">Date :</label>
        <input name="startDate" id="startDate" class="date-picker" />
    </div>
    <script>
        $(function() {
            $('.date-picker').datepicker(
                {
                    dateFormat: "dd/mm/yy",
                    changeMonth: true,
                    changeYear: true,
                    changeDay:true,
                    showButtonPanel: true,
                    onClose: function(dateText, inst) {


                        function isDonePressed(){
                            return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                        }

                        if (isDonePressed()){
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            var day = $("#ui-datepicker-div .ui-datepicker-day :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, day)).trigger('change');

                            $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                        }
                    },
                    beforeShow : function(input, inst) {

                        inst.dpDiv.addClass('month_year_datepicker')

                        if ((datestr = $(this).val()).length > 0) {
                            year = datestr.substring(datestr.length-4, datestr.length);
                            month = datestr.substring(0, 2);
                            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                            $(this).datepicker('setDate', new Date(year, month-1, 1));
                            $(".ui-datepicker-calendar").hide();
                        }
                    }
                })
        });
    </script>
    @endsection