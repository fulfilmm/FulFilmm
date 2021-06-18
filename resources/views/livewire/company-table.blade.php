<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Companies</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>CEO Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{$company->name}}</td>
                            <td>{{$company->address}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->ceo_name}}</td>
                            <td style="display: flex">
                                <a class="btn btn-primary" href="{{route('companies.show',$company->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success" href="{{route('companies.edit',$company->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('companies.destroy',$company->id)}}" id="del-company{{$company->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <a class="btn btn-danger" href="#" onclick="deleteRecord({{$company->id}})"><span class='fa fa-trash'></span></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{$companies->links()}}
        </div>
    </div>
</div>

