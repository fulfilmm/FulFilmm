@extends("layout.mainlayout")
@section('title','Add Variant')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Variant</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/products")}}">Product</a></li>
                        <li class="breadcrumb-item active">Variant Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
           <div class="card shadow">
               <div class="card-header">
                  Add {{$product->name}}'s Variants
               </div>
              <div class="col-12 my-3">
                  <form action="{{route('variant.store')}}" enctype="multipart/form-data" method="POST">
                      @csrf
                      <div class="row">
                          <input type="hidden" name="product_id" value="{{$product->id}}">
                          <div class="col">
                              <div class="form-group">
                                  <label for="">Images</label>
                                  <input type="file" name="picture[]" class="form-control" >
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label for="">Variant</label>
                                  <input type="text" class="form-control" name="variant[]" value="{{old('variant')}}" placeholder='Enter this format : "Color:Red Size:XL"'>
                                  @error('variant')
                                  <span class="text-danger">{{$message}}</span>
                                  @enderror
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label for="">Additional Price</label>
                                  <input type="number" class="form-control" name="additional_price[]" placeholder="Optional">
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

                          <div class="col-12 text-center">
                              <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                      </div>
                  </form>
              </div>
           </div>
        </div>
    </div>
    <script>
        $("#addRow").click(function () {
            var html = '';
            html +='<div id="inputFormRow" class="row">';
            html += '<div class="col">';
            html += '<div class="form-group mb-3">';
            html += '<div class="input-group">';
            html += '<input type="file" name="picture[]" class="form-control m-input" autocomplete="off" required>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html +='<div class="col">';
            html +='<div class="input-group">';
            html +='<input type="text" class="form-control" name="variant[]">';
            html +='</div>';
            html +='</div>';
            html += '<div  class="col">';
            html += '<div class="input-group">';
            html += '<input type="text" name="additional_price[]" class="form-control m-input amount" autocomplete="off" required placeholder="Optional">';
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
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
    @endsection