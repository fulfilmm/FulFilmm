@extends('layout.mainlayout')
@section('title','Prepare Po')
@section('content')

<div class="container-fluid content">
   <div class="card shadow">
      <div class="col-12 my-5">
          <form action="{{route('po_mail.sent')}}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="po_id" value="{{$po->id}}">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="">To</label>
                          <input type="email" name="email" class="form-control" value="{{$po->vendor->email}}">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="">CC</label>
                          <select name="cc[]" id="cc" class="form-control" multiple>
                              <option></option>
                          </select>
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <label for="">Mail Body</label>
                          <textarea name="body" id="description" cols="30" rows="10" class="form-control"></textarea>
                      </div>
                  </div>
                  <div class="col-12">
                      <div class="form-group">
                          <label for="">Attach</label>
                          <input type="file" name="attach" class="form-control">
                      </div>
                  </div>
                  <div class="col-12 text-center">
                      <button type="submit" class="btn btn-primary">Send</button>
                  </div>

              </div>
          </form>
      </div>
   </div>
</div>
<script>
  $(document).ready(function () {
      $("select").select2({
          tags: true,
          tokenSeparators: [',', ' ']
      })
  });
  ClassicEditor.create($('#description')[0], {
      toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
  });
</script>
        <!-- /Page Content -->
@endsection
