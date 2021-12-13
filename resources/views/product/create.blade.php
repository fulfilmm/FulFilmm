@extends("layout.mainlayout")
@section('title','Product Create')
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
        .remove:hover {
            background: white;
            color: black;
        }
    </style>
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route("products.store")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">General Product Detail</div>
                <div class="col-12 my-3">
                    <div class="row">
                        <div class="form-group col-md-4 col-12">
                            <label for="">Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Product Code</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="main_product_code">
                            </div>
                        </div>
                        <div class="col-md-4 col-12" id="tax_div">
                            <div class="form-group">
                                <label for="">Tax</label>
                                <div class="input-group">
                                    <select name="tax" id="product_tax" class="form-control" >
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}">{{$tax->name}}({{$tax->rate}}%)</option>
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select name="supplier_id" id="supplier" class="select">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">Model No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="model_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">Serial No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="serial_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Part No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="part_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Unit</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="unit" >
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Currency</label>
                            <select name="unit" id="" class="select">
                                <option value="MMK">MMK</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class=" col-md-4 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Main Category</label>
                                <div class="input-group">
                                    <select name="mian_cat" id="mian_cat" class="form-control" onchange="giveSelection(this.value)" >
                                        <option value="">Select Category</option>
                                        @foreach($category as $cat)
                                            @if($cat->parent==1)
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Sub Category</label>
                                <div class="input-group">
                                    <select name="sub_cat" id="sub_cat" class="form-control" >
                                        <option value="">Select Sub Category</option>
                                        @foreach($category as $cat)
                                            @if($cat->parent==0)
                                                <option value="{{$cat->id}}" data-option="{{$cat->parent_id}}">{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="stock_type">Stock Type</label>
                                <select name="stock_type" id="stock_type" class="form-control">
                                    <option value="Service"> Service</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="enable" value="1"
                                       checked>
                                <label class="custom-control-label" for="customSwitch1">Enabled</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12 ">
                            <label for="description">Detail</label>
                            <textarea name="detail" class="form-control" id="detail" ></textarea>
                        </div>
                    </div>
                </div>
              <div class="col-12">
                  <nav>
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Variants and Attribute</a>
                          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Attribute Setting</a>
                          {{--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>--}}
                      </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                          <div  id="variation" class="col-12">
                              <table class="table">
                                  <tr>
                                      <th>Attribute</th>
                                      <th>Value</th>
                                      <th>Action</th>
                                  </tr>
                                  <tbody>
                                   @foreach($v_type as $attribute)
                                       @if($attribute->active==1)
                                           {{--@dd($attribute->name)--}}
                                       <tr>
                                           <td><select name="type[]" id="" class="select2">
                                                   <option value="{{$attribute->id}}" selected>{{$attribute->name}}</option>
                                               </select>
                                           </td>
                                           <td>
                                               <select name="value{{$attribute->id}}[]" id="" class="select2" multiple>

                                               </select>
                                           </td>
                                           <td> <div class="custom-control custom-switch">
                                                   <input type="checkbox" class="custom-control-input" id="active{{$attribute->id}}" name="enable" value="1"
                                                           {{$attribute->active?'checked':''}}>
                                                   <label class="custom-control-label" for="active{{$attribute->id}}"></label>
                                               </div>
                                               <script>
                                                   $(document).ready(function () {
                                                       $('#active{{$attribute->id}}').on('click',function (event) {
                                                           if($(this).prop("checked") == true){
                                                               var enable=1;
                                                           }
                                                           else if($(this).prop("checked") == false){
                                                               var enable=0;
                                                           }
                                                           $.ajax({
                                                               data: {
                                                                   "enable": enable
                                                               },
                                                               type: 'POST',
                                                               url: "{{route('variant.active',$attribute->id)}}",
                                                               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                               success: function (data) {
                                                                   console.log(data);
                                                                   swal({
                                                                           title: "Variant",
                                                                           text: 'This variant is '+data.Account,
                                                                           type: "success"
                                                                       }
                                                                   ).then(function(){
                                                                       location.reload();
                                                                   });
                                                               }
                                                           });
                                                       });
                                                   });
                                               </script>
                                       </tr>
                                       @endif
                                       @endforeach
                                  </tbody>
                              </table>
                          </div>
                         <div class="col-12">
                             <div class="fom-group">
                                 <button href="#" type="button" data-toggle="modal" data-target="#add_variant" class="btn btn-white btn-sm text-primary" id="add_row">Add Attribute</button>
                             </div>
                         </div>
                      </div>

                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <table class="table">
                          <tr>
                              <th>Attribute</th>
                              <th>Action</th>
                          </tr>
                          <tbody>
                          @foreach($v_type as $attribute)
                                  <tr>
                                      <td>{{$attribute->name}}
                                      </td>
                                      <td> <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" id="active{{$attribute->id}}" name="enable" value="1"
                                                      {{$attribute->active?'checked':''}}>
                                              <label class="custom-control-label" for="active{{$attribute->id}}"></label>
                                          </div>
                                          <script>
                                              $(document).ready(function () {
                                                  $('#active{{$attribute->id}}').on('click',function (event) {
                                                      if($(this).prop("checked") == true){
                                                          var enable=1;
                                                      }
                                                      else if($(this).prop("checked") == false){
                                                          var enable=0;
                                                      }
                                                      $.ajax({
                                                          data: {
                                                              "enable": enable
                                                          },
                                                          type: 'POST',
                                                          url: "{{route('variant.active',$attribute->id)}}",
                                                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                          success: function (data) {
                                                              console.log(data);
                                                              swal({
                                                                      title: "Variant",
                                                                      text: 'This variant is '+data.Account,
                                                                      type: "success"
                                                                  }
                                                              ).then(function(){
                                                                  location.reload();
                                                              });
                                                          }
                                                      });
                                                  });
                                              });
                                          </script>
                                  </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
                  {{--<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>--}}
              </div>
              </div>
            <button type="submit" class="btn btn-primary text-center col-md-2 col-2 offset-md-5 my-3">Save</button>
            </div>
        </form>

    </div>

    <div class="modal fade" id="add_variant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="name" id="variant" class="form-control" placeholder="Type Variant">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" data-dismiss="modal" id="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        function selectRefresh(){
            $('.select2').select2({
                tags:true,
                allowClear: true,
                width:'100%',
            });
        }

        $(document).ready(function(){
            selectRefresh();
        });
        $(document).ready(function () {
            $(document).on('change','#product_cat',function () {
                var cat_id = $('#product_cat option:selected').val();
                @foreach($category as $cat)
                if (cat_id == "{{$cat->parent_id}}"){
                    $("#sub_cat").html("<option value={{$cat->id}}>{{$cat->name}}<option>");
                }
                @endforeach
            });
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        function openSelect(file) {
            $(file).trigger('click');
        }
        var sel1 = document.querySelector('#main_cat');
        var sel2 = document.querySelector('#sub_cat');
        var options2 = sel2.querySelectorAll('option');
        function giveSelection(selValue) {
            sel2.innerHTML = '';
            for(var i = 0; i < options2.length; i++) {
                if(options2[i].dataset.option === selValue) {
                    sel2.appendChild(options2[i]);
                }
            }
        }
        giveSelection(sel1);
        $(document).ready(function () {
            // $('select').select2({
            //         "language": {},
            //         escapeMarkup: function (markup) {
            //             return markup;
            //         }
            //     }
            // );
            $('#product_cat').select2({
                    "language": {},
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }
            );
        });
        $(document).ready(function () {
            $(document).on('click', '#add', function () {
                var variant_name = $('#variant').val();
                $.ajax({
                    data: {
                        active:1,
                        name: variant_name,
                    },
                    type: 'POST',
                    url: "{{url('product/variant/add')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.reload();
                        selectRefresh();
                    }

                });


            });
        });
    </script>
@endsection