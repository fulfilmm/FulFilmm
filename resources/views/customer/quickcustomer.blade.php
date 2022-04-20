<div id="add_contact" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Add New Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row g-3 date-icon-set-modal">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name"
                                           class="form-label font-weight-bold text-muted text-uppercase">Full
                                        Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" name="name" class="form-control" id="contact_name"
                                               placeholder="Enter Full Name" required>
                                    </div>
                                    <span class="text-danger name_err"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted text-uppercase">Gender<span
                                            class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="male" name="gender" value="Male"
                                               class="custom-control-input" checked>
                                        <label class="custom-control-label" for="male"><i
                                                    class="fa fa-male"></i> Male </label>
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="female" name="gender" value="Female"
                                               class="custom-control-input">
                                        <label class="custom-control-label" for="female"><i
                                                    class="fa fa-female"></i> Female </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_id" class="form-label font-weight-bold text-muted text-uppercase">Company
                                    Name<span class="text-danger">*</span></label>
                                <div class="input-group company_field">
                                    <select name="company_id" id="contact_company_id" class="form-control" style="width: 100%">
                                        @foreach($companies as $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email"
                                       class="form-label font-weight-bold text-muted text-uppercase">Email<span
                                            class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="contact_email" name="email"
                                           placeholder="Enter Email" required>
                                </div>
                                <span class="offset-md-3 email_err text-danger" role="alert"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone"
                                       class="form-label font-weight-bold text-muted text-uppercase">Phone<span
                                            class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="contact_phone" name="phone"
                                           placeholder="Enter Phone">
                                </div>
                            </div>
                            <input type="hidden" name="customer_type" value="Customer">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="credit_limit">Credit Limit</label>
                                    <input type="number" class="form-control" name="credit_limit" value="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="region_id">Region</label>
                                    <select name="region_id" id="quick_region_id" class="form-control select2" onchange="selectregion(this.value)" style="width: 100%">
                                        <option value="">None</option>
                                        @foreach($region as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="zone">Sale Zone</label>
                                    <div class="input-group">
                                        <select name="zone_id" id="quick_zone" class="form-control select2" style="width: 100%">
                                            <option value="">None</option>
                                            @foreach($zone as $item)
                                                <option value="{{$item->id}}" data-option="{{$item->region_id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button id="new_contact" data-dismiss="modal" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('company.quickcompany')
<script>
    $(document).ready(function () {
        $(document).on('click', '#new_contact', function () {
// alert('hello');
            var name = $('#contact_name').val();
            var gender = $('input[name="gender"]:checked').val();
            var company_id = $('#contact_company_id option:selected').val();
            var email = $('#contact_email').val();
            var phone = $('#contact_phone').val();
            var can_login=$('#canlogin').val();
            var region=$('#quick_region_id option:selected').val();
            var zone=$('#quick_zone option:selected').val();
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    gender: gender,
                    phone: phone,
                    email: email,
                    company_id: company_id,
                    canlogin:can_login,
                    zone_id:zone,
                    region_id:region,

                },
                url: "{{route('customers.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    location.reload();
                },
                error: function(xhr, status, error)
                {
                    swal("Error", "You have some validation errors in add contact!",'error');
                    $.each(xhr.responseJSON.errors, function (key, item)
                    {
                        $('.'+key+'_err').text(item);
                    });

                }
            });
        });
    });
    var quick_region = document.querySelector('#quick_region_id');
    var quick_zone = document.querySelector('#quick_zone');
    var quick_zone_optoion = quick_zone.querySelectorAll('option');
    // console.log(options3);
    // alert(product)
    function selectregion(selValue) {
        quick_zone.innerHTML='';

        for(var i = 0; i < quick_zone_optoion.length; i++) {
            if(quick_zone_optoion[i].dataset.option === selValue) {
                quick_zone.appendChild(quick_zone_optoion[i]);

            }
        }
    }
    selectregion(quick_region.value);
</script>