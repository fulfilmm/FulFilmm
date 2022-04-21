<div id="add_zone" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Add New Sales Zone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('salezone.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="branch">Branch</label>
                        <select name="branch" id="branch" class="form-control select2" onchange="selectregion(this.value)" style="width: 100%">
                            @foreach($branch as $bch)
                                <option value="{{$bch->id}}">{{$bch->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="region">Region</label>
                        <select name="region_id" id="region" class="form-control select2" style="width: 100%">
                            @foreach($region as $item)
                                <option value="{{$item->id}}" data-option="{{$item->branch_id}}">{{$item->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
       $('.select2').select2();
    });
    var branch = document.querySelector('#branch');
    var region = document.querySelector('#region');
    var region_option = region.querySelectorAll('option');
    // console.log(options3);
    // alert(product)
    function selectregion(selValue) {
        region.innerHTML='';

        for(var i = 0; i < region_option.length; i++) {
            if(region_option[i].dataset.option === selValue) {
                region.appendChild(region_option[i]);

            }
        }
    }
    selectregion(branch.value);
</script>