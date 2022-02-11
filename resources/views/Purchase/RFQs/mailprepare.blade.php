@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">RFQ Mail Prepare</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">RFQ</li>
                        <li class="breadcrumb-item active">Mail Prepare</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body border">
                    <form action="{{route('rfq.sendmail')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="">Email Address</label>
                                   <input type="email" name="email" class="form-control" value="{{$rfq->vendor->email}}">
                               </div>
                           </div>
                       </div>
                        <input type="hidden" name="vendor_name" value="{{$rfq->vendor->name}}">
                        <div class="form-group">
                            <label for="">Body</label>
                            <textarea name="body" id="description" cols="30" rows="10" class="form-group">
                                   Dear {{$rfq->vendor->name}},
                               </textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Attach</label>
                            <input type="file" name="attach" class="form-control">
                        </div>
                        <input type="hidden" name="rfq_id" value="{{$rfq->id}}">

                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
@endsection