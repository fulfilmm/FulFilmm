<template>
    <div class="container">

        <div class=" container-fluid rounded shadow-md px-3 py-4 my-2">
            <div class="row align-items-center">
                <div class="col-12">

                    <h3 class="page-title">Car Detail View</h3>
                    <ul class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><router-link :to="`/car-list`" class="bg-white px-3 py-2 my-2 text-decoration-none">Car List
                        </router-link></li>
                        <li class="breadcrumb-item">Details</li>
                    </ul>
                </div>
            </div>
            <form @submit.prevent="updateData">

                <div class="card shadow">
                    <div class="card-header">
                    <div class=" d-flex flex-row-reverse">
                        <div>

                        </div>
                        <button type="button" class="btn btn-success btn-sm mx-2" @click="edit" v-if="! this.editForm">
                            <span class="mr-2"><font-awesome-icon icon="pen-to-square"/></span>Edit
                        </button>

                        <button type="submit" class=" btn btn-white btn-sm text-info px-3 mx-2" v-if="this.editForm">
                           <i class="fa fa-save mr-2"></i>Update
                        </button>
                        <button type="button" class=" btn btn-danger btn-sm mx-2" @click="close" v-if="this.editForm">
                            <font-awesome-icon icon=" fa-xmark" class="mr-2"/>Cancel
                        </button>
                    </div>
                    </div>
                    <div class="col-12 my-5">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">License Number</div>
                                    <div class="col-6"><p v-if=" !this.editForm">: {{ car.license_no}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.license_no"
                                               v-if="this.editForm"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Car Brand
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.brand}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.brand" v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Car Model
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.model}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.model" v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Manufacture Company
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.manufacture}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.manufacture"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Engine Power
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.engine}}</p>
                                        <input type="text" class=" form-control shadow-md" v-model=" car.engine"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Horse Power
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.horsepower}}</p>
                                        <input type="text" class=" form-control shadow-md" v-model=" car.horsepower"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Chassis
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.chassis}}</p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.chassis"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Original Kilometer
                                    </div>
                                    <div class="col-6">
                                        :{{ car.kilometer}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Current Kilometer
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.upd_kilometer}}</p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.upd_kilometer"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        License Issue Date
                                    </div>
                                    <div class="col-6">
                                        <p v-if="! this.editForm">: {{ moment( car.license_issue_date ).format("MMM Do YYYY")}} </p>
                                        <date-picker v-model="car.license_issue_date" valueType="format" placeholder="choose date"
                                                     v-if="this.editForm"></date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        License Renew Date
                                    </div>
                                    <div class="col-6">
                                        <p v-if="! this.editForm">: {{ moment( car.license_renew_date ).format("MMM Do YYYY") }} </p>
                                        <date-picker v-model="car.license_renew_date" valueType="format" placeholder="choose date"
                                                     v-if="this.editForm"></date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Status
                                    </div>
                                    <div class="col-6">
                                        <div v-if="! car.status.length" class=" text-success text-sm font-weight-bold"> Working</div>

                                        <div v-else>
                                            <div v-for="s in car.status" :key="s.id">
                                                <div v-if="s.check == 0">
                                                    <div  v-if="s.status == 0" class="badge badge-warning rounded-pill"> Maintain </div>
                                                    <div  v-else-if="s.status == 1" class="badge badge-danger rounded-pill" > Repair </div>
                                                </div>
                                                <!-- <div v-else>
                                                   <p class="text-success text-sm font-weight-bold"> Working</p>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Fuel Type
                                    </div>
                                    <div class="col-6">
                                        <div v-if=" ! this.editForm">
                                            <p v-if="car.fuel_type == 0">: Petrol </p>
                                            <p v-if="car.fuel_type == 1">: Diesel </p>
                                        </div>
                                        <div v-if=" this.editForm">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                                    v-model="car.fuel_type">

                                                <option value="0">Petro</option>
                                                <option value="1">Diesel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                       Seat
                                    </div>
                                    <div class="col-6">
                                        <p v-if=" !this.editForm">: {{ car.seat}}</p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.seat" v-if="this.editForm">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Purchase Value
                                    </div>
                                    <div class="col-6">
                                        <p v-if="! this.editForm">: {{ car.purchase_value}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="car.purchase_value"
                                               v-if="this.editForm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                       Type
                                    </div>
                                    <div class="col-6">
                                        <p v-if="car.car_type == 0">: Rent </p>
                                        <p v-if="car.car_type == 1">: Own </p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="car.car_type == 0">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="row my-2">
                                        <div class="col-6">
                                            Original Owner
                                        </div>
                                        <div class="col-6">
                                            <p v-if="! this.editForm">: {{ car.org_owner_name}} </p>
                                            <input type="text" class=" form-control shadow-md" v-model="car.org_owner_name"
                                                   v-if="this.editForm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="row my-2">
                                        <div class="col-6">
                                            Contract Date
                                        </div>
                                        <div class="col-6">
                                            <p v-if="! this.editForm">: {{ moment( car.contract_date ).format("MMM Do YYYY")}} </p>
                                            <date-picker v-model="car.contract_date" valueType="format" placeholder="choose date"
                                                         v-if="this.editForm"></date-picker>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="row my-2">
                                        <div class="col-6">
                                            Contract Renew Date
                                        </div>
                                        <div class="col-6">
                                            <p v-if="! this.editForm">: {{ moment( car.renew_date ).format("MMM Do YYYY") }} </p>
                                            <date-picker v-model="car.renew_date" valueType="format" placeholder="choose date"
                                                         v-if="this.editForm"></date-picker>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="row my-2">
                                        <div class="col-6">
                                            Contract
                                        </div>
                                        <div class="col-6">
                                            : <a :href="`/download/`+car.contract"> {{ car.contract}} </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="row my-2">
                                        <div class="col-6">
                                            Description
                                        </div>
                                        <div class="col-6">
                                            : {{ car.description}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="row my-2">
                                    <div class="col-6">
                                        Attachment
                                    </div>
                                    <div class="col-6">
                                        :<p v-for="data  in car.attach" :key="data" class="text-small">
                                            <a :href="`/download/car-list/attach/`+data"> {{ data }} </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </form>

        </div>


    </div>
</template>
<script>

    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';

    export default {
        name: 'CarDetail',

        components: {DatePicker},

        data() {
            return {
                editForm: false,
                moment: moment,


                car: {}
            }
        },

        methods: {
            edit() {
                this.editForm = true;
            },

            close() {
                this.editForm = false;
            },

            updateData() {
                axios.patch(`/api/car_data/${this.$route.params.id}`, this.car)
                    .then(response => {
                        this.close();
                        console.log(response);
                    })
            },


        },

        created() {
            axios.get(`/api/car_data/${this.$route.params.id}`)
                .then(response => {
                    this.car = response.data;
                })
        }
    }
</script>
