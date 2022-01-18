<div id="add_new_company" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Add New Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                        <input type="text" id="company_name" class="form-control" name="name"
                                               title="Name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="business_type">
                                <div class="form-group">
                                    <label for="business_type">Type <span class="text-danger"> * </span></label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-building"></i></span>
                                        </div>
                                        <select name="business_type" class="form-control">
                                            <option value="IT">Information Technology</option>
                                            <option value="Trading">Trading</option>
                                            <option value="Service">Service</option>
                                            <option value="Delivery Service">Delivery Service</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <x-forms.basic.input name="company_phone" value="{{old('phone')}}" icon="phone"
                                                             title="Phone"
                                                             required></x-forms.basic.input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Email <span class="text-danger"> * </span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" id="comp_email" name="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">address</label>
                                    <input type="text" class="form-control" name="address" id="com_address">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group text-center">
                    <button id="new_company" data-dismiss="modal" class="btn btn-primary">Add</button>
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
            var email = $('#comp_email').val();
            var address = $('#com_address').val();
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    business_type: type,
                    phone: phone,
                    email: email,
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
</script>