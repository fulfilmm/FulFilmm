<div class="card">
    {{--  --}}
    <div class="card-header">
        <h4 class="card-title mb-0 d-inline">Groups</h4>
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
            @foreach ($groups as $group)
                <tr>
                    <td>{{$group->name}}</td>
                    <td>{{$group->created_by }}</td>
                    <td style="display: flex">
                    <a class="pr-2 my-auto btn btn-success" href="{{route('groups.edit',$group->id)}}">
                        <span class='fa fa-edit'></span>
                    </a>&nbsp;

                    <form  id="group-del-{{$group->id}}" action="{{route('groups.destroy',$group->id)}}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger" onclick="deleteRecord({{$group->id}})" type="submit"><span class='fa fa-trash'></span></button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $groups->links()}}
    </div>
    </div>

    </div>
