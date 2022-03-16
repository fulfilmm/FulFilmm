@extends('layout.mainlayout')
@section('title','Expense Claim ')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense Claim</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense Claim</li>
                    </ul>
                </div>
            </div>
        </div>
    <form method="POST" action="{{route('expenseclaims.store')}}" id="transaction" role="form" class="form-loading-button needs-validation" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="main_title" class="form-control" id="title" required>
                        @error('main_title')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="date" class="form-control" id="date" name="date" value="{{\Carbon\Carbon::parse(old('date'))->format('Y-m-d')}}">
                        </div>
                        @error('date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="approver">Approver</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <select name="approver" id="approver" class="form-control" style="width: 92%">
                            @foreach($employee as $emp)
                               @if($emp->role->name=='CEO'||$emp->role->name=='Manager')
                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('approver')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="finance approver">Finance Approver</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>

                        <select name="finance_approver" id="finance approver" class="form-control" style="width: 92%">
                            @foreach($employee as $emp)
                                @if($emp->department->name=='Finance Department')
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('finance_approver')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                   <div class="form-group">
                       <label for="tag">CC</label>
                       <div class="input-group">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><i class="fa fa-user"></i></span>
                           </div>
                           <select name="tag[]" id="tag" class="form-control" multiple style="width: 90%">
                               @foreach($employee as $emp)
                                   <option value="{{$emp->id}}">{{$emp->name}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="form-group">
                        <label for="attach">Attachment File</label>
                        <input type="file" name="attach[]" id="attach" class="form-control" multiple>
                    </div>

                </div>
                <div class="col-md-12 mb-2">
                    <label for="desc">Description</label>
                    <textarea name="description" id="desc" cols="30" rows="10" class="form-control"></textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                            </div>
                            <input type="text" class="form-control" name="title[]" id="title">
                        </div>
                        @error('title')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                            <input type="number" class="form-control amount" id="amount" name="amount[]">
                        </div>
                        @error('amount')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

            </div>
        <div id="newRow">

        </div>
            <div class="row">
                <div class="col-12">
                    <button id="addRow" type="button" class="btn btn-white btn-sm float-right">Add More</button>
                </div>
            </div>
           <div class="row my-3">
               <div class="col-md-6">
                   <strong class="float-right">Total</strong>
               </div>
               <div class="col-md-6">
                   <input type="number" name="total" class="form-control" id="total">
                   @error('total')
                   <span class="text-danger">{{$message}}</span>
                   @enderror
               </div>
           </div>

        </div>
        <div class="row save-buttons">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-icon btn-success"><!----> <span
                            class="btn-inner--text">Submit</span></button>
            </div>
        </div>
    </form>
        <script>
            $("#addRow").click(function () {
                var html = '';
                html +='<div id="inputFormRow" class="row">';
                html += '<div class="col-md-6">';
                html += '<div class="form-group mb-3">';
                html += '<div class="input-group">';
                html +='<div class="input-group-prepend">';
                html +='<span class="input-group-text"><i class="fa fa-pencil"></i></span>';
                html +='</div>';
                html += '<input type="text" name="title[]" class="form-control m-input" autocomplete="off" required>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '<div  class="col-md-6">';
                html += '<div class="input-group">';
                html +='<div class="input-group-prepend">';
                html +='<span class="input-group-text"><i class="fa fa-money"></i></span>';
                html +='</div>';
                html += '<input type="text" name="amount[]" class="form-control m-input amount" autocomplete="off" required>';
                html += '<div class="input-group-append">';
                html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fa fa-minus"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#newRow').append(html);
            });

            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
            ClassicEditor.create($('#desc')[0], {
                toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
            });
            $(document).on("keyup", ".amount", function() {
                var sum = 0;
                $(".amount").each(function(){
                    sum += +$(this).val();
                });
                $("#total").val(sum);
            });
            $(document).ready(function () {
                $('select').select2();
            });
        </script>
@endsection
