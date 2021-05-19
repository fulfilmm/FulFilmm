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
                    <th>Title</th>
                    <th>Created By
                    <th>
                </tr>
                </thead>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{$project->title}}</td>
                        <td>{{$project->creator->name }}</td>
                        <td style="display: flex">
                            <a class="pr-2 my-auto btn btn-success" href="{{route('projects.edit',$project->id)}}">
                                <span class='fa fa-edit'></span>
                            </a>&nbsp;

                            <form id="del-project-{{$project->id}}" action="{{route('projects.destroy',$project->id)}}"
                                  method="POST">
                                @method('delete')
                                @csrf
                                <a class="btn btn-danger" href="#" onclick="deleteRecord({{$project->id}})"><span
                                        class='fa fa-trash'></span></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $projects->links()}}
        </div>
    </div>

</div>
