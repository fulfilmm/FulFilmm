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
            </div>
        </div>
    </div>
    <div class="col-12 ">
        <form action="{{route('sellingunits.store')}}" method="POST">
            @csrf
           <div class="col-md-8 offset-md-2 card shadow">
               <div class="row my-5">
                   <div class="col-md-12">
                       <div class="form-group">
                           <label for="pid">Product Name</label>
                           <select name="variant_id[]" id="pid" class="form-control select2" multiple required >
                               @foreach($products as $pd)
                                   <option value="{{$pd->id}}">{{$pd->name}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                   <div class="col-md-12">
                       <div class="form-group">
                           <label for="unit">Unit</label>
                           <input type="text" name="unit" id="unit" class="form-control shadow-sm" placeholder="Enter Selling Unit" required>
                       </div>
                   </div>
                   <div class="col-md-12">
                       <div class="form-group">
                           <label for="price">Unit Convert Rate</label>
                           <input type="number" class="form-control shadow-sm" name="unit_convert_rate" placeholder="Enter Unit Convert Rate" required>
                       </div>
                   </div>
                   <div class="col-12 text-center">
                       <button type="submit" class="btn btn-primary shadow">Submit</button>
                   </div>
               </div>
           </div>
        </form>
    </div>
    <script>
        $(document).ready(function () {
           $('select').select2();
        });
    </script>
    @endsection