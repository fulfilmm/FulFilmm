<div class="modal fade" id="inquery{{$inquery->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Inquery</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="case_create" action="{{route('inqueries.update',$inquery->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Subject</label>
                                <input class="form-control" type="text" name="subject" value="{{$inquery->subject}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="client_name" class="form-control" value="{{$inquery->customer_name}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="">Age</label>
                                <input type="number" name="age" class="form-control" value="{{$inquery->age}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="client_phone" class="form-control"  min="0" required  oninput="validity.valid||(value='');" value="{{$inquery->phone}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{$inquery->email}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Township</label>
                                <select name="township" id="township" class="form-control">
                                    @foreach($townships as $key=>$value)
                                        @if($value==$inquery->townships)
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Product</label>
                                <select name="product_id[]" id="" class="select" multiple>
                                    @php
                                        $inquery_products=json_decode(($inquery->product));
                                    @endphp
                                    @for($i=0;$i<count($inquery_products);$i++ )
                                    @foreach($products as $product)
                                            @if($product->id==$inquery_products[$i])
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                            @else
                                                <option value="{{$product->id}}" >{{$product->name}}</option>
                                                @endif
                                    @endforeach
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="" rows="10" style="width: 100%;">{{$inquery->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right mr-2">Save</button>
                    <button type="button" class="btn btn-danger float-right mr-2" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
