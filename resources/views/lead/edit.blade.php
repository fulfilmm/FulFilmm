@extends('layout.mainlayout')
@section('title','Lead Edit')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- Page Wrapper -->
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Lead Edit</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url("")}}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{url("leads")}}">Lead</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Page Header -->
            <!--Main Content -->
            <div class="my-5">
                <form action="{{route("leads.update",$lead->id)}}" method="POST">
                   @csrf
                    @method('PUT')
                  <div class="row">
                      <div class="col-md-12 col-12">
                          <div class="card border">
                              <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="form-group col-md-6 col-xl-6 col-12">
                                      <label for="z">Lead ID</label>
                                      <input type="text" class="form-control" name="lead_id" value="{{$lead->lead_id}}">
                                  </div>
                                        <div class="form-group col-md-6 col-xl-6 col-12">
                                            <label for="">Lead Title</label>
                                            <input type="text" class="form-control" name="lead_title" value="{{$lead->title}}">
                                        </div>
                                    </div>
                                </div>
                              <div class="col-12">
                                  <div class="row">
                                      <div class="form-group col-md-6 col-xl-6 col-12">
                                          <label for="">Sale Man</label>
                                          <select name="sale_man" id="" class="select form-control">
                                              @foreach($allemployees as $key=>$value)
                                                  @if($key==$lead->sale_man_id)
                                                      <option value="{{$key}}" selected>{{$value}}</option>
                                                  @else
                                                      <option value="{{$key}}">{{$value}}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xl-6 col-12">
                                          <label for="">Customer Name</label>
                                          <select name="customer_id" id="add_customer" class="select col-md-9">
                                              @foreach($allcustomers as $key=>$value)
                                                  @if($key==$lead->customer_id)
                                                      <option value="{{$key}}" selected>{{$value}}</option>
                                                  @else
                                                      <option value="{{$key}}">{{$value}}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12">
                        <div class="row">
                            <div class="form-group col-md-6 col-xl-6 col-12" id="tags_reload">
                                <label for="">Tag Industry</label>
                                <select name="tags" id="category" class="select">
                                    @foreach($tags as $tag)
                                        @if($tag->id==$lead->tags_id)
                                            <option value="{{$tag->id}}" selected>{{$tag->tag_industry}}</option>
                                        @else
                                            <option value="{{$tag->id}}">{{$tag->tag_industry}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-xl-6 col-12">
                                <label for="">Organization</label>
                                <input type="text" class="form-control" name="org_name" value="{{$lead->organization_name}}">
                            </div>
                        </div>
                    </div>
                              <div class="col-12">
                             <div class="row">
                                 <div class="form-group col-md-6 col-xl-6 col-12">
                                     <label for="">Priority</label>
                                     <select name="priority" class="select" id="">
                                         @switch($lead->priority)
                                             @case('High'):<option value="High" selected>High</option>
                                             <option value="Medium">Medium</option>
                                             <option value="Low">Low</option>
                                             @break
                                             @case('Medium'):<option value="High">High</option>
                                             <option value="Medium" selected>Medium</option>
                                             <option value="Low">Low</option>
                                             @break
                                             @case('Low'):<option value="High" selected>High</option>
                                             <option value="Medium">Medium</option>
                                             <option value="Low"selected>Low</option>
                                             @break
                                         @endswitch

                                     </select>
                                 </div>
                                 <div class="col-md-6 col-xl-6 col-12">
                                     <label for="">Qualify Status</label>
                                     <div class="form-check form-switch">
                                         @if($lead->is_qualified==1)
                                             <input class="form-check-input" type="checkbox" id="check" name="qualified" checked>
                                             <label class="form-check-label" for="check">Qualified</label>
                                         @else
                                             <input class="form-check-input" type="checkbox" id="check" name="qualified">
                                             <label class="form-check-label" for="check">Qualified</label>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                         </div>
                              <div class="col-12">
    <div class="form-group">
        <label for="">Lead Description</label>
        <textarea name="description" id="description" class="form-control" rows="10">
                        {{$lead->description}}
                    </textarea>
    </div>
</div>
                          </div>
                      </div>
                      <div class="col-md-12 col-12">
                          <div class="card border">
                              <div class="row my-5">
                                  <div class="col-md-8 col-12">
                                      <div class="col-12">
                                          <div class="form-group mt-3">
                                              <label for="">Next Plan Description</label>
                                              <textarea name="next_plan_textarea" id="next_plan_textarea"  rows="6" class="form-control">
                                      @if($next_plan!=null)
                                                      {{$next_plan->description}}
                                                  @endif
                                  </textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group col-12">
                                          <label for="">From Date</label>
                                          @if($next_plan!=null)
                                              <input type="date" class="form-control" name="from_date" value="{{\Carbon\Carbon::parse($next_plan->from_date)->format('Y-m-d')}}">
                                          @else
                                              <input type="date" class="form-control" name="from_date">
                                          @endif
                                      </div>
                                      <div class="form-group col-12">
                                          <label for="">To Date</label>
                                          @if($next_plan!=null)
                                              <input type="date" class="form-control" name="to_date" value="{{\Carbon\Carbon::parse($next_plan->to_date)->format('Y-m-d')}}">
                                          @else
                                              <input type="date" class="form-control" name="to_date">
                                          @endif
                                      </div>
                                  </div>
                              </div>

                          </div>

                      </div>
                  </div>
                    <div class="form-group text-center ">
                        @if($lead->is_qualified==1)
                            <button id="button" class='btn btn-outline-primary col-3 rounded-pill' type='submit'>Qualified and Update</button>
                        @else
                            <button id="button" class='btn btn-outline-primary col-3 rounded-pill' type='submit'>Update</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <!-- /Page Wrapper -->
        <script>
            $(document).ready(function(){ //Make script DOM ready
                $('#category').change(function() { //jQuery Change Function
                    var opval = $(this).val(); //Get value from select element
                    if(opval=="category"){ //Compare it and if true
                        $('#add').modal("show"); //Open Modal
                    }
                });
            });
            $(document).ready(function() {
                $(document).on('click', '#tags_create', function () {
                    var tags=$("#tags").val();
                    $.ajax({
                        type:'POST',
                        data : {tag_industry:tags},
                        url:'/tags/create',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            window.location.reload(true);
                        }
                    });
                });
            });
                $("#check").on("click", function(){
                    if($("#check").is(":checked")){
                        $("#button").text("Qualified and Update");
                    }else {
                        $("#button").text("Update");
                    }
                });

        </script>
@endsection