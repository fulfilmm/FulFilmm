<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap datatable mb-0 table-hover">
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
                            <td><img src="{{$company->logo}}" class="avatar avatar-sm" alt="">{{$company->name}}</td>
                            <td>{{$company->address}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->ceo_name}}</td>
                            <td style="display: flex">
                                <a class="btn btn-primary btn-sm" href="{{route('companies.show',$company->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success btn-sm" href="{{route('companies.edit',$company->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('companies.destroy',$company->id)}}" id="del-company{{$company->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="deleteRecord({{$company->id}})"><span class='fa fa-trash'></span></button>
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

