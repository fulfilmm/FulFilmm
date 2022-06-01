@extends("layout.mainlayout")
@section('title','Product Details')
@section("content")
    <style>
        input[type="file"] {
            display: block;
        }

        .imageThumb {
            max-height: 90px;
            max-width: 150px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 10px 0;
        }

        .remove {
            display: block;
            background: #edeff2;
            border: 1px solid black;
            color: black;
            text-align: center;
            cursor: pointer;
        }
    </style>
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$product->name}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/products")}}">Product</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <ul class="nav nav-tabs " id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                   aria-selected="false"><i class="la la-cube mr-2"></i>Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true"><i class="fa fa-list mr-2"></i>About Product</a>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card col-12 shadow">
                    <div class="card-header">
                        <h4>Product Specification</h4>
                    </div>
                    <div class="col-12 mt-3">
                         <div class="row">
                             <span class="text-muted col-md-2">Product Name </span><span class="col-md-10">: {{$product->name}}</span>
                         </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="row">
                        <span class="text-muted col-md-2">Model No </span><span class="col-md-10">: {{$product->model_no??'N/A'}}</span>
                        </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="row">
                        <span class="text-muted col-md-2">Main Category</span><span class="col-md-10">: {{$product->category->name??''}}</span>
                        </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="row">
                        <span class="text-muted col-md-2">Sub-Category</span><span class="col-md-10">: {{$product->sub_cat->name??'N/A'}}</span>
                        </div>
                    </div>
                    <div class="col-12 my-1">
                        <div class="row">
                        <span class="text-muted col-md-2">Brand</span><span class="col-md-10">: {{$product->sub_cat->name??'N/A'}}</span>
                        </div>
                    </div>
                        <div class="col-12">
                            <h5>Description</h5>
                           <div class="border" style="min-height: 100px">
                              <p class="mx-3 my-3"> {!! $product->description !!}</p>
                           </div>
                        </div>

                   <div class="col-12 my-3">
                       <h5>Images</h5>
                       <div class="row my-1">
                               <img src="{{url(asset('/product_picture/'.$product->image))}}" alt="" class="border mr-2 ml-2" style="max-height:200px;max-width:100%;border: solid">
                       </div>
                   </div>

                </div>
            </div>
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="ml-2 col-md-4 col-12 float-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control" name="action" id="action_type" style="width: 70%">
                                        <option value="Enable">Enable</option>
                                        <option value="Disable">Disable</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <button type="button" id="confirm" class="btn btn-primary rounded-right">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
               <div style="overflow: auto">
                   <table class="table table-nowrap table-hover">
                       <thead>
                       <tr>
                           <th><input type="checkbox" name="all" id="checkall"></th>
                           <th></th>
                           <th>Product Name</th>
                           <th>Item Code</th>
                           <th>Variants</th>
                           <th>Disable/Enable</th>
                           <th>Price Rule</th>
                           <th>Created Date</th>
                           <th>Action</th>

                       </tr>
                       </thead>
                       <tbody>
                       @foreach($variantions as $item)
                           <tr>
                               <td>
                                   <input type="checkbox"  name="product[]" value="{{$item->id}}" class="single">
                               </td>
                               <td> <img src="{{url(asset('/product_picture/'.$item->image))}}" alt="" class="border-0 mr-2 ml-2"
                                         style="max-height:50px;max-width:50px;border: solid"></td>
                               <td>{{$item->product->name}}</td>
                               <td><a href="{{route('show.variant',$item->id)}}"><strong>{{$item->item_code}}</strong></a></td>
                               <td>{{$item->variant}}</td>
                               <td>{{$item->enable==0?'Disable':'Enable'}}</td>
                               <td>{{$item->pricing_type?'Multiple Price Rule':'Single Price Rule'}}</td>
                               <td>{{$item->created_at->toFormattedDateString()}}</td>
                               <td>
                                   <div class="row">
                                       <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}" title="Item edit"><i class="la la-edit"></i></button>
                                       <a href="{{route('show.variant',$item->id)}}" class="btn btn-white btn-sm" title="Item details view"><i class="la la-eye"></i></a>
                                       <form action="{{route('barcode.generate')}}" method="get">
                                           @csrf
                                           <input type="hidden" name="product_name" value="{{$item->id}}">
                                           <button type="submit" class="btn btn-primary btn-sm" title="Barcode Generate"><i class="la la-barcode"></i></button>
                                       </form>
                                   </div>
                                   <div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                       <div class="modal-dialog modal-dialog-centered modal-lg">
                                           <div class="modal-content">
                                               <div class="modal-header border-bottom">
                                                   <h5 class="modal-title">Update Product Variant</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                       <span aria-hidden="true">&times;</span>
                                                   </button>
                                               </div>
                                               <div class="modal-body">
                                                   <form action="{{route('variant.update',$item->id)}}" enctype="multipart/form-data" method="POST">
                                                       @csrf
                                                       <div class="row">
                                                           <input type="hidden" name="product_id" value="{{$product->id}}">
                                                           <div class="col-md-4">
                                                               <div class="form-group">
                                                                   <label for="">Product Code</label>
                                                                   <div class="input-group">
                                                                       <input type="text" id="p_code" name="product_code" class="form-control" value="{{$item->product_code}}" readonly required>
                                                                   </div>
                                                                   @error('product_code')
                                                                   <span class="text-danger">{{$message}}</span>
                                                                   @enderror
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4">
                                                               <div class="form-group">
                                                                   <label for="">Serial No.</label>
                                                                   <input type="text" class="form-control" name="serial_no" value="{{$item->serial_no}}">
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4">
                                                               <div class="form-group">
                                                                   <label for="">Variant</label>
                                                                   <input type="text" class="form-control" name="variant" value="{{$item->variant}}" placeholder='Enter this format : "Color:Red Size:XL"'>
                                                                   @error('variant')
                                                                   <span class="text-danger">{{$message}}</span>
                                                                   @enderror
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4">
                                                               <div class="form-group">
                                                                   <input type="radio" name="pricing_type" value="0" id="single" {{$item->pricing_type?"":"checked"}}>
                                                                   <label for="single">Single Price</label>
                                                                   <input type="radio" name="pricing_type" value="1" id="multi" {{$item->pricing_type?'checked':''}}>
                                                                   <label for="multi">Multi Price</label>
                                                               </div>
                                                           </div>
                                                           <div class="col-md-12">
                                                               <div class="form-group">
                                                                   <label for="">Images</label>
                                                                   <input type="file" name="picture" class="form-control" >
                                                               </div>
                                                           </div>

                                                           <div class="col-md-12">
                                                               <div class="form-group">
                                                                   <label for="">Description</label>
                                                                   <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$item->description}}</textarea>
                                                               </div>
                                                           </div>
                                                           <div class="col-12 text-center">
                                                               <button type="submit" class="btn btn-primary">Add</button>
                                                           </div>
                                                       </div>
                                                   </form>
                                               </div>
                                           </div>
                                       </div>
                                   </div>

                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
    </div>
    <script>
        function generatecode(){
            var pcode='{{random_int(10000000,99999999)}}';
            $("#generate_code").val(pcode);
        }
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
        $('#checkall').change(function () {
            $('.single').prop('checked',this.checked);
        });

        $('.single').change(function () {
            if ($('.single:checked').length == $('.single').length){
                $('#checkall').prop('checked',true);
            }
            else {
                $('#checkall').prop('checked',false);
                // $(".action").remove();
            }
        });
        $(document).ready(function() {
            $('select').select2();
            $(document).on('click', '#confirm', function () {
                var product_id =new Array();
                $(".single").each(function () {
                    // console.log($(this).val()); //works fine
                    if($(this).is(":checked")){
                        product_id.push($(this).val());
                    }
                });
                var action_type=$( "#action_type option:selected" ).val();
                if(product_id.length!=0){
                    $.ajax({
                        type:'POST',
                        data : {action_Type:action_type,product_id:product_id},
                        url:'/action/confirm',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            window.location.reload();
                        }
                    });
                }else {
                    swal('Empty Checked','Please Checkbox checked first!','warning');
                }
            });
        });
    </script>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
@endsection
