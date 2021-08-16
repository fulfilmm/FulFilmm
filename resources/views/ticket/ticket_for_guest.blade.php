@extends("layout.mainlayout")
@section('title',"Ticket Create")
@section('content')
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
    {{-- Modals --}}
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="card col-md-8 offset-md-2 col-12 my-3">
            <div class="card-header">
                <div class="row">
                    @php $company=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp

                    <div class="col-9">
                        <h3>Ticket Request Form</h3>
                    </div>
                    <span class="mr-2 mt-2">{{$company->name ??''}}</span><img src="{{$company!=null?url(asset('/img/profiles/'.$company->logo)):''}}" width="40px" height="40px"></span>
                </div>
            </div>
    <form action="{{route('request_tickets.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" value="{{old('name')}}" name="name" class="form-control" >
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="text" value="{{old('email')}}" name="email" class="form-control" >
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Phone <span class="text-danger">*</span></label>
                    <input type="number" value="{{old('phone')}}" name="phone" class="form-control"  min="0" oninput="validity.valid||(value='');">
                @error('client_phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Address <span class="text-danger">*</span></label>
                    <input type="text" value="{{old('address')}}" name="address" class="form-control">
                    @error('address')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Product <span class="text-danger">*</span></label>
                    <select name="product_id" id="" class="select">
                        @foreach($products as $key=>$val)
                            <option value="{{$key}}" {{old('product_id')==$key?'selected':''}}>{{$val}}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Company <span class="text-danger">*</span></label>
                    <select name="company_id" id="" class="select">
                        @foreach($customercompany as $key=>$val)
                            <option value="{{$key}}" {{old('company_id')==$key?'selected':''}}>{{$val}}</option>
                        @endforeach
                            <option value="">Other</option>
                    </select>
                    @error('company_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="guest_description" name="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Upload Files</label>
                    <input class="form-control" name="attach_file" type="file">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class=" form-group">
                    <label align="center">Upload your images</label>
                    <input type="file" class="form-control"  id="files" name="files[]" multiple  />
                </div>
            </div>
        </div>
        <div class="submit-section">
            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
        </div>
    </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<div class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><div class=\"remove\"><i class='fa fa-remove'>Remove</div>" +
                                "</div>").insertAfter("#files");
                            $(".remove").click(function(){
                                $(this).parent(".pip").remove("file");
                            });


                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });

        ClassicEditor
            .create( document.querySelector( '#guest_description' ) );
    </script>
@endsection
