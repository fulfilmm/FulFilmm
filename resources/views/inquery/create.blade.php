@extends("layout.mainlayout")
@section('title',"InQuery Create")
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="col-md-10 offset-md-1 col-12">
            <h3 class="my-3">Inquery Create </h3>
            <form action="{{route('inqueries.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input class="form-control" id="subject" type="text" name="subject" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="client_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                          <label for="age">Age</label>
                          <input type="number" id="age" name="age" class="form-control">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" id="phone" name="client_phone" class="form-control"  min="0" required  oninput="validity.valid||(value='');">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="township">Township</label>
                            <input type="text" id="township" class="form-control" name="township" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Product</label>
                            <select name="product_id[]" id="" class="select" multiple required>
                                @foreach($products as $product)
                                    <option value={{$product->id}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Convert To Lead</label>
                           <div class="group">
                               <input type="radio" id="yes" name="convert" value="1">
                               <label for="yes">Yes</label>
                               <input type="radio" id="not_now" name="convert" checked value="0">
                               <label for="not_now">Not Now</label>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="" rows="10" style="width: 100%;" required></textarea>
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
            $('#township').select2({
                    "language": {
                        "noResults": function(){
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }

                }

            );
        });
    </script>
@endsection
