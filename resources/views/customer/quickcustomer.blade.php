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
                                <label for="company_id"
                                       class="form-label font-weight-bold text-muted text-uppercase">Company
                                    Name<span class="text-danger">*</span></label>
                                <div class="input-group" id="company_div">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-building"></i></span>
                                    </div>
                                    <select name="company_id" id="contact_company_id" class="form-control">
                                        @foreach($companies as $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" data-toggle="modal" data-target="#add_new_company" class="btn btn-white"><i class="fa fa-plus"></i></button>
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
                                @error('email')
                                <span class="offset-md-3 text-danger" role="alert">{{ $message }}</span>
                                @enderror
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
                            <div class="col-md-6 mb-3" id="refesh_div">
                                <label for="customer_type"
                                       class="form-label font-weight-bold text-muted text-uppercase">
                                    Type</label>
                                <select name="customer_type" id="customer_type" class="form-control">
                                    <option value="Customer">Customer</option>
                                    <option value="Lead">Lead</option>
                                    <option value="In Query">In Query</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Competitor">Competitor</option>
                                    <option value="Supplier">Supplier</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">

                            </div>
                            <div class="col-md-6 mb-3" id="priority">

                            </div>
                            <div class="col-md-6 mb-3" id="tag_industry">

                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="canlogin" id="canlogin" value="off">
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
<script>
    $(document).ready(function () {
        $(document).on('click', '#new_company', function () {
// alert('hello');
            var name = $('#company_name').val();

            var type = $('#business_type option:selected').val();
            var phone = $('#company_phone').val();
            var email = $('#email').val();
            var ceo_name = $('#company_ceo_name').val();
            var company_registry = $('#company_registry').val();
            var address = $('#company_address').val();
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    business_type: type,
                    phone: phone,
                    email: email,
                    ceo_name: ceo_name,
                    company_registry: company_registry,
                    address: address
                },
                url: "{{route('companies.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    $("#company_div").load(location.href + " #company_div>* ");
                }
            });
        });
    });
    $(document).ready(function () {
        $(document).on('click', '#new_contact', function () {
// alert('hello');
            var name = $('#contact_name').val();
            var gender = $('input[name="gender"]:checked').val();
            var company_id = $('#contact_company_id option:selected').val();
            alert(company_id);
            var email = $('#contact_email').val();
            var phone = $('#contact_phone').val();
            var type = $('#customer_type option:selected').val();
            var can_login=$('#canlogin').val();
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    gender: gender,
                    phone: phone,
                    email: email,
                    company_id: company_id,
                    customer_type: type,
                    canlogin:can_login

                },
                url: "{{route('customers.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    $("#contact_div").load(location.href + " #contact_div>* ");
                }
            });
        });
    });
</script>