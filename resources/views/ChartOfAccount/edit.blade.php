<div id="edit_coa{{$coa->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 my-3">
                    <form action="{{route('chartofaccount.update',$coa->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="code"> <span class="text-danger">*</span>Code</label>
                            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" required value="{{$coa->code}}">
                        </div>
                        <div class="form-group">
                            <label for="name"><span class="text-danger">*</span> Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required value="{{$coa->name}}">
                        </div>
                        <div class="form-group">
                            <label for="actype">Account Type</label>
                            <select name="type" id="actype" class="form-control">
                                <option value="">Select Account Type</option>
                                @foreach($types as $item)
                                    <option value="{{$item->id}}" {{$coa->type==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="financial_statement">Financial Statement</label>
                            <input type="text" class="form-control" name="financial_statement" id="financial_statement" value="{{$coa->financial_statement}}" placeholder="Enter Financial Statement (optional)">
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" class="form-control" name="group" id="group" placeholder="Enter Group(optional)" value="{{$coa->group}}">
                        </div>
                        <div class="form-group">
                            <label for="subgroup">Sub Group</label>
                            <input type="text" class="form-control" name="sub_group" id="subgroup" placeholder="Enter Sub-Group(optional)" value="{{$coa->sub_group}}">
                        </div>
                        <div class="row justify-content-center">
                            <div class="form-group">
                                <input type="radio" name="normally" value="Debt" {{$coa->normally=='Debt'?'checked':''}}>
                                <label for="">Debt</label>
                            </div>
                            <div class="form-group ml-5">
                                <input type="radio" name="normally" value="Credit" {{$coa->normally=='Credit'?'checked':''}}>
                                <label for="">Credit</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>