@extends('layout.mainlayout')
@section('title','Quotation Send Mail')
@section('content')
    <form action="{{route('quotations.mail')}}" enctype="multipart/form-data" method="post">
        {{csrf_field()}}
        <div class="col-md-10 offset-md-1 col-12 my-2" id="content">
            <div class=" card ">
                <div class="card-header">
                    <div class="row">
                        {{--@php $company=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp--}}
                        <div class="col-md-4">
                            <h4>{{$quotation->quotation_id}} </h4>
                        </div>
                        <div class="col-md-8 col-6">
                            <div class="row">
                                <div class="col-10 col-10 text-right">
                                    <span class="float-right">{{$company->name??''}}</span><br>
                                    <span>{{$company->address ?? ''}}</span>
                                </div>
                                <div class="col-md-2 col-2">
                                    @if(isset($company->logo))
                                        <img src="{{url(asset('/img/profiles/'.$company->logo))}}" width="40px"
                                             height="40px">
                                        @else
                                        <img src="" width="40px"
                                             height="40px" alt="Company Logo">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <strong class="ml-3"></strong>
                    <div class="row">
                        <div class="col-4 offset-md-8">
                            <div class="row">
                                <div class="col-5">
                                    <label for="">Expiration </label>
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <span>: {{\Carbon\Carbon::parse($quotation->exp_date)->toFormattedDateString()}}</span>
                                        <input type="hidden" value="{{$quotation->exp_date}}" name="exp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 float-right">
                        <div class="row">
                            <div class="col-5">
                                <label for="">PaymentTerms</label>
                            </div>
                            <div class="col-7">
                                <span> : {{$quotation->payment_term}}</span>
                                <input type="hidden" value="{{$quotation->payment_term}}" name="pay_term">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12" style="overflow-x: auto">
                    <h4>Order Line</h4>
                    <table class="table">
                        <thead>
                        <th scope="col">Product</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        </thead>
                        <tbody id="tbody">
                        @foreach($orderline as $order)
                            <tr>
                                <td>
                                    {{$order->variant->product_name}}
                                    <p>{{$order->variant->variant??''}}</p>
                                </td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->unit->unit}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->discount}}</td>
                                <td>{{$order->total_amount}}
                                    <input type="hidden" class="total" value="{{$order->total_amount}}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="3">Total</th>

                            <td colspan="2">{{$quotation->total}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="3">Discount</th>

                            <td colspan="2">{{$quotation->discount}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="3">Tax (Rate %)</th>
                            <td colspan="2">{{$quotation->tax_amount}} ({{$quotation->tax->rate}} %)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="3">Grand Total</th>

                            <td colspan="2">{{$quotation->grand_total}}</td>
                        </tr>
                    </table>
                </div>
                <div class="form-group ml-3 mb-5">
                    <h4>Terms and Conditions</h4>
                    <ul style="list-style-type: disc">
                        <li>{{$quotation->terms_conditions}}</li>
                        <li>{{$quotation->terms_conditions}}</li>
                    </ul>

                    <input type="hidden" name="term_condition" class="form-control" style="width: 90%"
                           value="{{$quotation->terms_conditions}}">
                </div>
                <div class="card-footer">
                    <div class="col-12 text-center">
                        {{$company->web_link??''}}
                    </div>
                    <div class="col-12 text-center">
                        {{isset($company->email) ? 'Email: '.$company->email.',':''}}
                    </div>
                    <div class="col-12 text-center">
                        {{isset($company->phone) ?'Phone:'.$company->phone.',':''}}
                         {{isset($company->mobile_phone) ?'Mobile Phone:'.$company->mobile_phone.',':''}}
                        {{isset($company->fax) ?'Fax:'.$company->fax:''}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 offset-md-1 col-12 my-2">
            <input type="hidden" value="{{$company}}" name="company">
            <input type="hidden" name="client_name" value="{{$quotation->customer->name}}">
            <div class="offset-md-9 mt-3">

                <input type="hidden" value="{{$quotation->id}}" name="id">
            </div>
            <div class="col-md-12 card mt-2">
                <div class="form-group mt-3">
                    <label for="">Subject</label>
                    <input class="form-control" type="text" name="subject">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">To</label>
                            <input class="form-control" type="text" value="{{$quotation->customer->email}}"
                                   name="email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Cc</label>
                            <input class="form-control" type="text" name="email_cc">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Attach File</label>
                            <input class="form-control" type="file" name="attch">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary float-right mr-5 "> Send</button>
            </div>
        </div>
    </form>
@endsection