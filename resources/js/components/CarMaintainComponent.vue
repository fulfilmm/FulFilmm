<template>
    <div class="content container-fluid">
        <div class="row align-items-center">
            <div class="col-12">

                <h3 class="page-title">Car Maintainence</h3>
                <ul class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <router-link :to="`/car-list`" class="bg-white px-3 py-2 my-2 text-decoration-none">Car List
                        </router-link>
                    </li>
                    <li class="breadcrumb-item">List</li>
                </ul>
                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn btn-primary rounded-pill shadow-lg px-3 mb-5" data-toggle="modal"
                            data-target=".bd-example-modal-xl">
                        Upload Maintainence Record
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            License Number :{{car.license_no}}
                        </div>
                        <div class="col">
                            Model :{{car.model}}
                        </div>
                        <div class="col">
                            Engine Power :{{car.engine}}
                        </div>
                    </div>
                </div>
                <div class="col-12 my-3">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"> Status</th>
                            <th scope="col"> Kilometer</th>
                            <th scope="col"> Workshop</th>
                            <!-- <th scope="col"> Case  </th> -->
                            <th scope="col"> Info</th>
                            <th scope="col"> Service Date</th>
                            <th scope="col"> Detail</th>
                            <th scope="col"> Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="maintain in car.status" :key="maintain.id">


                            <td>

                                <div v-if="maintain.status == 0"> Maintain</div>
                                <div v-else-if="maintain.status == 1"> Repair</div>
                            </td>

                            <td> {{maintain.kilometer}}</td>
                            <td> {{maintain.workshop}}</td>
                            <!-- <td> {{maintain.case}}</td> -->
                            <td class="">
                                <div class="row">
                                    <div class="col text-sm font-weight-bold text-sm">


                                        <div v-if="maintain.check == 0" class="text-danger"> Still Maintain</div>
                                        <div v-else-if=" maintain.check ==1" class="text-success"> Done</div>


                                        <!-- <div v-if="editForm">
                                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="checkForm.check">

                                                      <option value="0">Still Maintain</option>
                                                      <option value="1">Done</option>

                                                  </select>
                                               </div> -->

                                    </div>
                                    <!-- <div class="col">
                                          <button type="button" class="btn text-success text-sm border-none" @click="edit" v-if="! editForm"> <font-awesome-icon icon="pen-to-square" /> </button>

                                           <button type="submit" class="btn text-info text-sm" v-if="editForm" @click="updateForm(maintain.id)"> <font-awesome-icon icon="fa-file-arrow-up" /> </button>
                                           <button type="button" class="btn text-danger text-sm" @click="close" v-if="editForm"> <font-awesome-icon icon=" fa-xmark" /> </button>
                                    </div> -->

                                </div>


                            </td>

                            <td>
                                {{ moment( maintain.service_date ).format("MMM Do YYYY") }}
                            </td>

                            <!-- <td v-for="c in maintain.case" :key="c.id">
                               <p v-for="d in c" :key="d.id">{{d}}</p>
                            </td> -->

                            <!-- <td>
                              <p v-for="c in JSON.parse(maintain.case)" :key="c.id">
                                   {{ c.case }} || {{ c.expense}}
                              </p>

                            </td> -->


                            <td>
                                <router-link :to="`/maintain/${maintain.id}`"
                                             class=" btn btn-info shodow-md px-3 border-none rounded-pill text-white">
                                    Detail
                                </router-link>
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger rounded-pill" @click="destroy(maintain.id)">
                                    Delete
                                </button>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!------------------------------------ upload record  ------------------------------------------------->
        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-12">
                            <form @submit.prevent="store" class="row">

                                <div class="alert alert-success" v-show="success"> Data Created Successfully</div>

                                <!--
                                            <div class="form-group col-md-6 col-sm-12">
                                              <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Select Car</label>
                                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.car_id">
                                                    <option  v-for=" car in cars" :key="car.id" :value="car.id">{{car.license_no}}</option>
                                                </select>

                                                 <span class="text-small text-danger" v-if="errors && errors.car_id">
                                                      {{ errors.car_id[0] }}
                                                  </span>
                                            </div> -->

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Add Car
                                                    Status</label>
                                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0"
                                                        v-model="maintain.status">

                                                    <option value="0">Maintain</option>
                                                    <option value="1">Repair</option>
                                                </select>

                                                <span class="text-small text-danger" v-if="errors && errors.status">
                                          {{ errors.status[0] }}
                                      </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 border">
                                    <form @submit.prevent="cases">

                                        <h4 class="mt-3">Input Case Records </h4>

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="forn-group">
                                                    <input type="text" class="form-control rounded"
                                                           placeholder="Input Case"
                                                           v-model="form.case">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class=" form-group">
                                                    <input type="text" class="form-control rounded"
                                                           placeholder="Input Expense"
                                                           v-model="form.expense">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                             <div class="col">
                                                 <label for="issue_date" class="mx-4"> Start Date</label>
                                                 <date-picker v-model="form.start_date" valueType="format" placeholder="choose date"></date-picker>
                                             </div>

                                              <div class="col">
                                                 <label for="issue_date" class="mx-4"> Expire Date</label>
                                                 <date-picker v-model="form.end_date" valueType="format" placeholder="choose date"></date-picker>
                                             </div>
                                        </div> -->


                                        <div class="my-2">
                                            <button class="btn btn-success" type="submit"> Add Me</button>
                                        </div>

                                    </form>

                                    <div class="col-12 mb-3">
                                        <table class="table p-3 text-center">
                                            <thead>
                                            <tr>
                                                <th> Case</th>
                                                <th> Expanse</th>
                                                <!-- <th> state_date</th> -->
                                                <!-- <th> end_date</th> -->
                                                <th> Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(c, index) in maintain.records" :key="c.id">
                                                <td scope="row"> {{c.case}}</td>
                                                <td> {{c.expense}}</td>
                                                <!-- <td>{{c.start_date}}</td> -->
                                                <!-- <td>{{c.end_date}}</td> -->
                                                <td>
                                                    <button class="btn btn-danger" @click="deleteCases(index)"> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> Total</td>
                                                <td>{{totalAmt}}</td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label"> Input Description</label>
                                                <textarea class="form-control" v-model="maintain.description"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class=" form-group">
                                                <input type="text" v-model="maintain.kilometer" class="form-control"
                                                       placeholder="Please Fill Current Kilometer" aria-describedby="helpId">
                                                <span class="text-small text-danger" v-if="errors && errors.kilometer">
                                          {{ errors.kilometer[0] }}
                                      </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class=" form-group">
                                                <input type="text" v-model="maintain.workshop" class="form-control"
                                                       placeholder="Please Fill Workshop Name" aria-describedby="helpId">
                                                <span class="text-small text-danger" v-if="errors && errors.workshop">
                                          {{ errors.workshop[0] }}
                                      </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">

                                                <div>
                                                    <label for="issue_date" class="mx-4"> Service Date</label><br>
                                                    <date-picker v-model="maintain.service_date" valueType="format"
                                                                 placeholder="choose date"></date-picker>
                                                </div>

                                                <div class="text-small text-danger" v-if="errors && errors.service_date">
                                                    {{ errors.service_date[0] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Select
                                                    Driver</label>
                                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0"
                                                        v-model="maintain.driver">

                                                    <option value="0">U Ba</option>
                                                    <option value="1">U Mya</option>
                                                    <option value="2">U Hla</option>
                                                </select>
                                                <span class="text-small text-danger" v-if="errors && errors.driver">
                                          {{ errors.driver[0] }}
                                      </span>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class=" form-group mb-3">
                                                <label for="" class="form-label"> Upload Attach</label>
                                                <input type="file" class="form-control" @change="selectfiles" ref="files"
                                                       multiple/>

                                                <span class="text-small text-danger" v-if="errors && errors.attaches">
                                          {{ errors.attaches[0] }}
                                      </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger " data-dismiss="modal">Close Box
                                        </button>
                                        <button type="submit" class="btn btn-success">Upload Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';

    export default {
        name: 'CarMaintain',

        components: {DatePicker},


        data() {
            return {

                moment: moment,

                car_id: this.$route.params.id,

                car: {},

                errors: {},

                editForm: false,

                success: false,

                maintain: {
                    status: '',
                    car_id: this.$route.params.id,
                    records: [],
                    description: '',
                    kilometer: '',
                    workshop: '',
                    service_date: '',
                    driver: '',
                    attaches: [],
                },

                checkForm: {
                    check: '',
                },

                form: {
                    case: '',
                    expense: '',
                },
            }
        },

        methods: {

            reset() {
                this.maintain = {
                    status: '',
                    car_id: this.$route.params.id,
                    //car_id:'',
                    records: [],
                    description: '',
                    kilometer: '',
                    workshop: '',
                    service_date: '',
                    driver: '',
                    attaches: [],
                }
                //  this.form = {
                //    case:'',
                //    expense:'',
                //  }
            },

            //for case array
            cases() {
                const data = {
                    case: this.form.case,
                    expense: this.form.expense,
                }

                this.maintain.records.push(data);
                this.form = [];
            },

            deleteCases(index) {
                this.maintain.records.splice(index);
            },

            view() {
                axios.get(`/api/car_data/${this.$route.params.id}`)
                    .then((response) => {
                        this.car = response.data;
                    })
                    .catch(err => console.log(err));
            },


            //  edit(){
            //     this.editForm = true ;
            // },

            // close() {
            //     this.editForm = false ;
            // },


            selectfiles() {
                for (let i = 0; i < this.$refs.files.files.length; i++) {
                    this.maintain.attaches.push(this.$refs.files.files[i]);

                    console.log(this.maintain.attaches);
                }
            },

            store() {

                var self = this;

                let cases = JSON.stringify(this.maintain.records);

                const data = new FormData();

                data.append('status', this.maintain.status);
                data.append('car_id', this.maintain.car_id);
                data.append('case', cases);
                data.append('description', this.maintain.description);
                data.append('kilometer', this.maintain.kilometer);
                data.append('workshop', this.maintain.workshop);
                data.append('service_date', this.maintain.service_date);
                data.append('driver', this.maintain.driver);

                for (let i = 0; i < this.maintain.attaches.length; i++) {
                    let file = self.maintain.attaches[i];

                    data.append('attaches[' + i + ']', file);
                }
                data.append('total', this.totalAmt)

                const config = {
                    header: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }

                axios.post("/api/maintainance", data, config)
                    .then((response) => {
                        this.reset();
                        this.view();
                        self.$refs.files.value = '';
                        this.success = true;
                        this.errors = {};
                        console.log(response);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        console.log(error);

                    })
            },

            updateForm(id) {
                axios.patch(`/api/maintainance/${id}`, this.checkForm)
                    .then(response => {
                        this.close();
                        console.log(response);
                    })

                    .catch(err => console.log(err));

            },

            destroy(id) {
                if (!confirm('Are You Sure To Delete')) return;
                axios.delete(`/api/maintainance/${id}`)
                    .then((response) => {
                        this.view();
                    })
            }

        },

        created() {
            this.view();
        },

        computed: {
            totalAmt() {
                if (!this.maintain.records) {
                    return 0;
                }

                return this.maintain.records.reduce(function (totalAmt, records) {
                    return totalAmt + Number(records.expense);
                }, 0);
            }
        }
    }
</script>