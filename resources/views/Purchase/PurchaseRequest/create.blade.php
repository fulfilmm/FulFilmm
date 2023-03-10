@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Request Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Purchase
                                Request</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card shadow">
           <div class="col-12 my-5">
               <form action="{{route('purchase_request.store')}}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <div class="row">
                       <div class="col-md-3">
                           <div class="form-group">
                               <label for="">Supplier(optional)</label>
                               <select name="vendor_id" id="supplier" class="form-control select2">
                                   <option value="">None</option>
                                   @foreach($suppliers as $supplier)
                                       <option value="{{$supplier->id}}" {{isset($pr_data)?($pr_data[0]['supplier_id']==$supplier->id?'selected':''):''}}>{{$supplier->name}}</option>
                                   @endforeach
                               </select>
                               @error('vendor_id')
                               <i class="text-danger">{{$message}}</i>
                               @enderror
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="form-group">
                               <label for="">Approver <span class="text-danger">*</span></label>
                               <select name="approver_id" id="approver" class="form-control select2">
                                   <option value="">Select Approver</option>
                                   @foreach($approvers as $approver)
                                       @if($approver->role->name=='Manager'||$approver->role->name=='CEO')
                                           <option value="{{$approver->id}}" {{isset($pr_data)?($pr_data[0]['approver_id']==$approver->id?'selected':''):''}}>{{$approver->name}}</option>
                                       @endif
                                   @endforeach
                               </select>
                               @error('approver_id')
                               <i class="text-danger">{{$message}}</i>
                               @enderror
                           </div>
                       </div>
                       {{--                @dd()--}}
                       <div class="col-md-3">
                           <div class="form-group">
                               <label for="">Purchase Type <span class="text-danger">*</span></label>
                               <select name="type" id="type" class="select2">
                                   <option value="Re-Sale" {{isset($pr_data)?($pr_data[0]['type']=='Re-Sale'?'selected':''):''}}>Re-Sale</option>
                                   <option value="Office Use" {{isset($pr_data)?($pr_data[0]['type']=='Office Use'?'selected':''):''}}>Office Use</option>
                               </select>
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="form-group">
                               <label for="">Deadline <span class="text-danger">*</span></label>
                               <input type="date" name="deadline" id="deadline" class="form-control" value="{{$pr_data[0]['deadline']??''}}" >
                               @error('deadline')
                               <i class="text-danger">{{$message}}</i>
                               @enderror
                           </div>

                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="">Tag</label>
                               <select name="tag[]" id="tag" class="form-control select2" multiple>
                                   @foreach($emps as $key=>$val )
                                     @if(isset($pr_data[0]['emp']))
                                           <option value="{{$key}}" @foreach($pr_data[0]['emp'][0] as $index=>$item) {{$item==$key?'selected':''}} @endforeach>{{$val}}</option>
                                         @else
                                           <option value="{{$key}}">{{$val}}</option>
                                         @endif
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-12">
                           <label for="">Description</label>
                           <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{$pr_data[0]['desc']??''}}</textarea>
                       </div>

                   </div>
                   <input type="hidden" id="creation_id" value="{{$creation_id[0]}}">
                   <div class="row my-3">
                       <div class="col-12" style="overflow: auto">
                           <strong>Items</strong>
                           <table class="table table-hover">
                               <thead>
                               <th scope="col" style="min-width: 200px;">Product</th>
                               <th scope="col">Description</th>
                               <th>Quantity</th>
                               <th>Unit</th>
                               <th>Price</th>
                               <th>Total</th>
                               <th>Action</th>
                               </thead>
                               <tbody id="tbody">
                               @foreach($items as $item)
                                   <input type="hidden" name="item" value="{{$item->id}}">
                                   <tr>
                                       <td>
                                           {{$item->product->name}}

                                       </td>
                                       <td>{{$item->description}}</td>
                                       <td>{{$item->qty??''}}</td>
                                       <td>{{$item->unit}}</td>
                                       <td>{{$item->price??0}}</td>
                                       <td>{{$item->total??''}}
                                       </td>
                                       <td style="min-width: 60px;">
                                           <div class="row">
                                               <button type="button" data-toggle="modal" data-target="#edit{{$item->id}}"
                                                       class="btn btn-success btn-sm mt-1"><i
                                                           class="fa fa-edit"></i></button>
                                               <button type="button" id="delete_{{$item->id}}"
                                                       class="btn btn-danger btn-sm mt-1"><i
                                                           class="fa fa-minus"></i></button>
                                               <div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                                   <div class="modal-dialog modal-dialog-centered modal-md">
                                                       <div class="modal-content">
                                                           <div class="modal-header">
                                                               <h5 class="modal-title">Edit Item</h5>
                                                               <button type="button" class="close" data-dismiss="modal"
                                                                       aria-label="Close">
                                                                   <span aria-hidden="true">&times;</span>
                                                               </button>
                                                           </div>
                                                           <div class="modal-body">
                                                               <div class="form-group ">
                                                                   <div class="row">
                                                                       <label class="col-md-3">Product</label>
                                                                       <div class="col-md-9">
                                                                           <select name="[]" id="product{{$item->id}}"
                                                                                   class="form-control select2 update{{$item->id}}">
                                                                               @foreach($product as $key=>$value)
                                                                                   <option value="{{$key}}" {{$key==$item->product_id?'selected':''}}>{{$value}}</option>
                                                                               @endforeach
                                                                           </select>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                               <div class="form-group">
                                                                   <div class="row">
                                                                       <label for="" class="col-md-3">Description</label>
                                                                       <div class="col-md-9">
                                                                    <textarea name="" id="desc{{$item->id}}" cols="30" rows="2"
                                                                              class="form-control  update{{$item->id}}">{{$item->description}}</textarea>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                               <div class="form-group">
                                                                   <div class="row">
                                                                       <label for="" class="col-md-3">Qty</label>
                                                                       <div class="col-md-9">
                                                                           <input type="number" id="qty{{$item->id}}"
                                                                                  class="form-control update{{$item->id}}"
                                                                                  name="qty"
                                                                                  value="{{$item->qty??''}}"></div>
                                                                   </div>
                                                               </div>
                                                               <div class="form-group">
                                                                   <div class="row">
                                                                       <label for="" class="col-md-3">Unit</label>
                                                                       <div class="col-md-9">
                                                                           <input type="text" id="unit{{$item->id}}"
                                                                                  class="form-control update{{$item->id}}"
                                                                                  name="unit"
                                                                                  value="{{$item->unit??''}}"></div>
                                                                   </div>
                                                               </div>
                                                               <div class="form-group">
                                                                   <div class="row">
                                                                       <label for="" class="col-md-3">Price</label>
                                                                       <div class="col-md-9">
                                                                           <input type="number" id="price{{$item->id}}"
                                                                                  class="form-control update{{$item->id}}"
                                                                                  name="price"
                                                                                  value="{{$item->price??''}}">
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                               <div class="form-group">
                                                                   <div class="row">
                                                                       <label for="" class="col-md-3">Total</label>
                                                                       <div class="col-md-9">
                                                                           <input class="form-control" type="text"
                                                                                  id="total{{$item->id}}"
                                                                                  value="{{$item->total??''}}">
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                               <button id="update_item{{$item->id}}" data-dismiss="modal"
                                                                       class="btn btn-primary float-right">Save
                                                               </button>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>


                                           </div>
                                           <script>
                                               $(document).on('click', '#update_item{{$item->id}}', function (event) {
                                                   var description = $('#desc{{$item->id}}').val();
                                                   var product = $('#product{{$item->id}} option:selected').val();
                                                   var qty=$('#qty{{$item->id}}').val();
                                                   var price = $('#price{{$item->id}}').val();
                                                   var total = $('#total{{$item->id}}').val();
                                                   var unit=$('#unit{{$item->id}}').val();
                                                   $.ajax({
                                                       data: {
                                                           description: description,
                                                           product_id: product,
                                                           qty:qty,
                                                           price: price,
                                                           total:total,
                                                           unit:unit

                                                       },
                                                       type: 'POST',
                                                       url: "{{url('/pr/item/update/'.$item->id)}}",
                                                       async: false,
                                                       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                       success: function (data) {
                                                           console.log(data);
                                                           location.reload();
                                                           selectRefresh();
                                                       }
                                                   });

                                               });
                                               $(document).ready(function () {
                                                   $('.update{{$item->id}}').keyup(function () {
                                                       var quantiy = $('#qty{{$item->id}}').val();
                                                       var price = $('#price{{$item->id}}').val();
                                                       var total = quantiy * price;
                                                       $('#total{{$item->id}}').val(total);
                                                   });
                                               });
                                               $(document).on('click', '#delete_{{$item->id}}', function (event) {
                                                   // alert('hello');
                                                   $.ajax({
                                                       data: {
                                                           item_id: "{{$item->id}}"

                                                       },
                                                       type: 'POST',
                                                       url: "{{url('/pr/item/delete')}}",
                                                       async: false,
                                                       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                       success: function (data) {
                                                           console.log(data);
                                                           location.reload();
                                                           selectRefresh();
                                                       }
                                                   });

                                               });
                                           </script>
                                       </td>
                                   </tr>
                               @endforeach
                               @error('item')
                               <tr>
                                   <td>  <i class="text-danger">! Empty Item</i></td>
                               </tr>
                               @enderror
                               <tr id="add_row">
                                   <td>
                                       <select name="[]" id="product" class="form-control select2 item_save">
                                           <option value="" selected>Select Product</option>
                                           @foreach($product as $key=>$value)
                                               <option value="{{$key}}">{{$value}}</option>
                                           @endforeach
                                       </select>
                                   </td>
                                   <td>
                                       <button type="button" id="remove" class="btn btn-danger btn-sm mt-1"><i
                                                   class="fa fa-close"></i></button>

                                   </td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>

                               </tr>
                               <tr>
                                   <td colspan="7">
                                       <button type="button" id="add" class="btn btn-white btn-sm">Add</button>
                                   </td>
                               </tr>
                               </tbody>
                           </table>

                       </div>
                   </div>
                   <hr>

                   <div class="col-md-12">
                       <div class="form-group">
                           <label for="">Attachment Files</label>
                           <input type="file" name="file[]" class="form-control" id="attach" multiple>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-12 text-center">
                           <button type="submit" class="btn btn-primary">Submit</button>
                       </div>
                   </div>
               </form>
           </div>
        </div>
    </div>
    <script>
        function selectRefresh() {
            $('.select2').select2({
                tags: true,
                allowClear: true,
                width: '100%'
            });
        }

        $(document).ready(function () {
            selectRefresh();
        });
        $(document).ready(function () {
            $('#add_row').hide();
        });
        $(document).on('click', '#add', function () {
            $('#add_row').show();
        });
        $(document).on('click', '#remove', function () {
            $('#add_row').hide();
        });
        $(document).ready(function () {
            $('input').keyup(function () {
                var quantiy = $('#qty').val();
                var price = $('#price').val();
                var total = quantiy * price;
                $('#total').val(total);
            });
        });

        function loadlink() {
            $('#links').load('head.blade.php', function () {
                $(this).unwrap();
            });
        }

        $(document).on('change', '#product', function (event) {
            var emp =new Array();
            $("#tag").each(function () {
                // console.log($(this).val()); //works fine
                emp.push($(this).val());
            });
            var supplier = $('#supplier option:selected').val();
            var approver = $('#approver option:selected').val();
            var deadline = $('#deadline').val();
            var desc = $('#description').val();
            var description = $('#desc').val();
            var product = $('#product option:selected').val();
            var price = $('#price').val();
            var type=$('#type option:selected').val();
            var creation_id = $('#creation_id').val();
            $.ajax({
                data: {
                    supplier_id: supplier,
                    approver_id: approver,
                    deadline: deadline,
                    description: description,
                    product_id: product,
                    qty: 1,
                    price: price,
                    total: 0,
                    creation_id: creation_id,
                    desc: desc,
                    emp:emp,
                    unit:'PCS',
                    type:type

                },
                type: 'POST',
                url: "{{url('/pr/item/add')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                    selectRefresh();
                }
            });

        });
    </script>
@endsection