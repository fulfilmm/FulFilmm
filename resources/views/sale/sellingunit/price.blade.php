@extends("layout.mainlayout")
@section('title','Add Selling Unit')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Selling Unit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("sellingunits")}}">Selling Unit</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a  class="btn btn-white float-right mr-3 mt-3 shadow rounded-pill" data-toggle="modal" data-target="#add_price" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New Price</a>
                </div>
            </div>
        </div>
        <div class="col-12">
           <div class="card shadow">
              <div class="col-12 my-5" style="overflow: auto">
                  <table class="table table-nowrap table-hover my-5" id="price_table">
                      <thead>
                      <tr>
                          <th>Product Code</th>
                          <th>Product Name</th>
                          <th>Variants</th>
                          <th>Unit</th>
                          <th>Sale Price</th>
                          <th>Sale Type</th>
                          <th>Created Date</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($price_lists as $item)
                          <tr>
                              <td><strong>{{$item->variant->product_code}}</strong></td>
                              <td>{{$item->variant->product_name}}</td>
                              <td>{{$item->variant->variant}}</td>
                              <td>{{$item->unit->unit}}</td>
                              <td>{{$item->price}}</td>
                              <td>{{$item->sale_type}}</td>
                              <td>{{$item->created_at->toFormattedDateString()}}</td>
                              <td style="min-width: 120px;">
                                  <div class="row justify-content-center">
                                      @if($item->active)
                                          <a href="{{url('price/inactive/'.$item->id)}}" class="btn btn-success btn-sm mr-1">Active</a>
                                      @else
                                          <a href="{{url('price/active/'.$item->id)}}" class="btn btn-danger btn-sm mr-1">Inactive</a>
                                      @endif
                                      <a href="#" data-toggle="modal" data-target="#edit_{{$item->id}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                                      <a href="{{route('sellprice.destroy',$item->id)}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></a>
                                  </div>
                                  <div id="edit_{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                      <div class="modal-dialog modal-dialog-centered modal-md">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title">Update New Price</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="col-12">
                                                      <form action="{{route('sellprice.update',$item->id)}}" method="POST">
                                                          @csrf
                                                          <div class="col-md-12">
                                                              <div class="row">
                                                                  <div class="col-md-6">
                                                                      <div class="form-group">
                                                                          <label for="pid">Product Name</label>
                                                                          <div class="input-group">
                                                                          <select name="product_id" id="update_pid{{$item->id}}" onchange="giveSelection(this.value)" class="form-control" style="width: 100%" required>
                                                                              @foreach($products as $pd)
                                                                                  <option value="{{$pd->id}}" {{$item->variant->id==$pd->id?'selected':''}}>{{$pd->product_name}}({{$pd->variant}})</option>
                                                                              @endforeach
                                                                          </select>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <div class="form-group">
                                                                          <label for="unit_id">Unit</label>
                                                                          <div class="input-group">
                                                                              <select name="unit_id" id="unit_id{{$item->id}}" class="form-control" required  style="width: 100%">
                                                                                  @foreach($units as $unit)
                                                                                      <option value="{{$unit->id}}" data-option="{{$unit->variant_id}}" {{$item->unit_id==$unit->id?'selected':''}}>{{$unit->unit}}</option>
                                                                                  @endforeach
                                                                              </select>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <div class="form-group">
                                                                          <label for="sale_type">Sale Type</label>
                                                                         <div class="input-group">
                                                                             <select name="sale_type" id="sale_type{{$item->id}}" class="form-control" style="width: 100%">
                                                                                 <option value="Whole Sale" {{$item->sale_type=='Whole Sale'?'selected':''}}>Whole Sale</option>
                                                                                 <option value="Retail Sale" {{$item->sale_type=='Retail Sale'?'selected':''}}>Retail Sale</option>
                                                                             </select>
                                                                         </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <div class="form-group">
                                                                          <label for="price">Unit Price</label>
                                                                          <input type="number" class="form-control" name="price" value="{{$item->price}}" required>
                                                                      </div>
                                                                  </div>
                                                                  <div class="col-12 text-center">
                                                                      <button type="submit" class="btn btn-primary">Submit</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
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

    <div id="add_price" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <form action="{{route('store.price')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pid">Product Name</label>
                                            <select  id="main_pid" onchange="giveSelection(this.value)" class="form-control select2 shadow"  style="width: 100%" required>
                                                @foreach($main_product as $pd)
                                                    <option value="{{$pd->id}}">{{$pd->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pid">Variant</label>
                                            <select name="product_id[]" id="pid"  class="form-control select2 shadow" multiple style="width: 100%" required>
                                                @foreach($products as $pd)
                                                    <option value="{{$pd->id}}" data-option="{{$pd->product_id}}">{{$pd->variant}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_id">Unit</label>
                                            <div class="input-group">
                                                <select name="unit_id" id="unit_id" class="form-control" required  style="width: 100%">
                                                    @foreach($units as $unit)
                                                        <option value="{{$unit->id}}" data-option="{{$unit->product_id}}">{{$unit->unit}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sale_type">Sale Type</label>
                                            <select name="sale_type" id="sale_type" class="form-control" style="width: 100%">
                                                <option value="Whole Sale">Whole Sale</option>
                                                <option value="Retail Sale">Retail Sale</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Unit Price</label>
                                            <input type="number" class="form-control shadow-sm" name="price" placeholder="Enter Unit Price" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    </div>
        <script>
            var product = document.querySelector('#main_pid');
            var unit = document.querySelector('#unit_id');
            var pid = document.querySelector('#pid');
            var options2 = unit.querySelectorAll('option');
            var options3 = pid.querySelectorAll('option');
            console.log(options3);
            function giveSelection(selValue) {
                unit.innerHTML = '';
                pid.innerHTML = '';
                for(var i = 0; i < options2.length; i++) {
                    if(options2[i].dataset.option === selValue) {
                        unit.appendChild(options2[i]);
                        pid.appendChild(options3[i]);
                    }
                }
            }
            giveSelection(product.value);
        </script>
        <script>
            $(document).ready(function () {
               $('select').select2();
                $('#price_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [ 0,1, 2,3,4,5,6 ]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [ 0,1, 2,3,4,5,6 ]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [ 0,1, 2,3,4,5,6 ]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            exportOptions: {
                                columns: [ 0,1, 2,3,4,5,6 ]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [ 0,1, 2,3,4,5,6 ]
                            }
                        },
                        'colvis'
                    ]
                });
            });

        </script>
@endsection