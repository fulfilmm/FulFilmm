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
                    <a href="{{route('add_price')}}" class="btn btn-white float-right mr-3 mt-3 shadow rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New Price</a>
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
                          <th>Pricing Type</th>
                          <th>Sale Type</th>
                          <th>Office</th>
                          <th>Rule Description</th>
                          <th>Range</th>
                          <th>Unit</th>
                          <th>Sale Price</th>
                          <th>Date Limit</th>
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
                              <td>{{$item->multi_price?'Multiple Price Rule':'Single Price Rule'}}</td>
                              <td>{{$item->sale_type}}</td>
                              <td>{{$item->branch->name}}</td>
                              <td>{{$item->rule}}</td>
                              <td>{{$item->min}} - {{$item->max}}</td>
                              <td>{{$item->unit->unit}}</td>
                              <td>{{$item->price}}</td>
                              <td>{{$item->start_date?\Carbon\Carbon::parse($item->start_date)->toFormattedDateString():'N/A'}} - {{$item->end_date?\Carbon\Carbon::parse($item->end_date)->toFormattedDateString():'N/A'}}</td>
                              <td>{{$item->created_at->toFormattedDateString()}}</td>
                              <td style="min-width: 120px;">
                                  <div class="row justify-content-center">
                                      @if($item->active)
                                          <a href="{{url('price/inactive/'.$item->id)}}" class="btn btn-success btn-sm mr-1">Active</a>
                                      @else
                                          <a href="{{url('price/active/'.$item->id)}}" class="btn btn-danger btn-sm mr-1">Inactive</a>
                                      @endif
                                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}"><i class="la la-edit"></i></button>
                                      <a href="{{route('sellprice.destroy',$item->id)}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></a>
                                          <div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm">
                                                  <div class="modal-content">
                                                      <div class="modal-header border-bottom">
                                                          <h5 class="modal-title">Update Price</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                          </button>
                                                      </div>
                                                      <form action="{{route('sellprice.update',$item->id)}}" method="POST">
                                                      <div class="modal-body">
                                                              @csrf
                                                              <div class="col-md-12">
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          <div class="form-group">
                                                                              <label for="price">Unit Price</label>
                                                                              <input type="number" class="form-control shadow-sm" name="price" value="{{$item->price}}">
                                                                          </div>
                                                                      </div>
                                                                      <div class="col-12 text-center">
                                                                          <button type="submit" class="btn btn-primary">Submit</button>
                                                                      </div>
                                                                  </div>
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
        <script>
            $(document).ready(function () {
               $('.select2').select2();
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