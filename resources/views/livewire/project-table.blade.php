<div class="card">
    {{--  --}}
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Projects</h4>
        <div class="float-right">
            <input type="text" wire:model="search_key">
        </div>
    </div>
    {{-- <a href={{url('/employees/export')}}><button  class="btn btn-primary ml-2">Export</button></a> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0 ">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Created By<th>
                </tr>
                </thead>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td>{{$project->created_by }}</td>
                        <td style="display: flex">
                            <a class="pr-2 my-auto btn btn-success" href="{{route('project.edit',$project->id)}}">
                                <span class='fa fa-edit'></span>
                            </a>&nbsp;

                            <form  id="project-del-{{$project->id}}" action="{{route('project.destroy',$project->id)}}" method="POST">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="deleteRecord({{$project->id}})" type="submit"><span class='fa fa-trash'></span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $projects->links()}}
        </div>
    </div>

</div>
