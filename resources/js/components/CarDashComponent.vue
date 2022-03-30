<template>
  <div class=" container-fluid">
      <!-- Button trigger modal -->

            <div class=" d-flex flex-row-reverse mt-3">
                <button type="button" class="btn btn-primary rounded-pill shadow-lg px-3 mb-5" data-toggle="modal" data-target=".bd-example-modal-xl">
                    Upload New Car Data
                </button>
            </div>

            <div class=" container-fluid my-4">
                <table class="table table-striped">
                  <thead>
                    <tr>
                   
                      <th scope="col"> License Number</th>
                      <th scope="col"> Brand </th>
                      <th scope="col"> Model </th>
                      <th scope="col"> Status </th>
                      <th scope="col"> Alert  </th>
                      <th scope="col"> Notice</th>
                      <th scope="col"> Maintain </th>
                      <th scope="col"> Schedule </th>
                      <th scope="col"> Detail</th>
                      <th scope="col"> Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="car in cars" :key="car.id">
                      
                      <td> {{car.license_no}}</td>
                      <td> {{car.brand}}</td>
                      <td> {{ car.model}}</td>
                      <td> 
                
                        <div>
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
                       
                      </td>

                      <td class=""> 
                        <span class="badge badge-danger rounded-pill"  v-if="car.license_renew_date <= lastMonth"> License Expire Soon</span>
                        <span class="badge badge-success rounded-pill"  v-else> Nothing Happen </span>   
                      </td>

                      <td class="">
                        <div v-for="data in car.routines" :key="data.id">
                          <div v-if="data.check == 0">
                            <div v-for="d in JSON.parse(data.case)" :key="d.id">
                             
                                    
                                    <small class="text-danger" v-if="d.end_date <= lastMonth"> {{ d.case}} || {{ d.end_date }} </small>
                                    <!--<small class="" v-else>  {{ d.end_date }} </small> -->
                              
                            </div>
                          </div>
                         </div>
                             


                              

                      </td>

                      <td>
                          <a :href="`/car-list/car-maintain/${car.id}`" class="btn btn-success rounded-pill text-white"> <font-awesome-icon icon="fa-solid fa-clipboard-list" /> </a>
                      </td>

                        <td>
                          <a :href="`/car-list/car-record/${car.id}`" class="btn btn-secondary rounded-pill text-white"> <font-awesome-icon icon="fa-solid fa-notes-medical" /> </a>
                        </td>

                      
                      <td> <a :href="`/car-list/${car.id}`"  class=" btn btn-info rounded-pill text-white"> <font-awesome-icon icon="fa-circle-info" /> </a> </td>

                      <td>
                        <button type="button" class="btn btn-danger rounded-pill" @click="destroy(car.id)"> <font-awesome-icon icon="fa-trash-can" />  </button>
                      </td>
                    
                    </tr>
                    
                  </tbody>
                </table>
            </div>
      
               
                       
                <!-- upload data Modal -->
               <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-body">
                    
                            <form @submit.prevent="store" class="row">
                              <div class="alert alert-success" v-show="success"> Data Created Successfully</div>
                                <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.license_no" class="form-control" placeholder=" Please Fill License Number" aria-describedby="helpId" required>
                                  <small class="text-danger font-weight-bold font-italic text-left">  Required  </small>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <input type="text"  v-model="car.brand" class="form-control" placeholder="Please Fill Car Brand" aria-describedby="helpId" required>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.model"  class="form-control" placeholder="Please Fill Car Model" aria-describedby="helpId" required>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.manufacture" class="form-control" placeholder="Please Fill Manufacturing Company" aria-describedby="helpId" required>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.engine" class="form-control" placeholder="Please Fill Engine Type" aria-describedby="helpId" required>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.horsepower" class="form-control" placeholder="Please Fill Horsepower" aria-describedby="helpId" required>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.chassis" class="form-control" placeholder="Please Fill Chassis" aria-describedby="helpId" required>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <input type="text" v-model="car.kilometer" class="form-control" placeholder="Please Fill Original Kilometer" aria-describedby="helpId">
                                </div>

                                <div class="form-group col-md-6 col-sm-12 mx-auto d-flex">
                                      <label for="issue_date" class="mx-4"> License Issue Date</label>
                                      <date-picker v-model="car.license_issue_date" valueType="format" placeholder="choose date"></date-picker>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12 mx-auto d-flex">
                                      <label for="renew_date" class="mx-4"> License Renew Date </label>
                                      <date-picker v-model="car.license_renew_date" valueType="format" placeholder="choose date"></date-picker>
                                </div>


                                 <!-- <div class="form-group col-md-6 col-sm-12">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Add Car Status</label>
                                  <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="car.status" required>
                                   
                                    <option value="0">Working</option>
                                    <option value="1">Maintain</option>
                                    <option value="2">Repair</option>
                                  </select>
                                </div> -->

                                 <div class="form-group">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect">Please Add Fuel Types</label>
                                  <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="car.fuel_type" required>
                                  
                                    <option value="0">Petro</option>
                                    <option value="1">Diesel</option>
                                  </select>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12">
                                      <input type="text" v-model="car.seat" class="form-control" placeholder="Seat" aria-describedby="helpId" required>
                                </div>

                                 <div class="form-group col-md-6 col-sm-12">
                                      <input type="text" v-model="car.purchase_value" class="form-control" placeholder="Purchase Value" aria-describedby="helpId">
                                </div>

                                <div class="form-group">
                                    <label class="mr-sm-2" for="inlineFormCustomSelect1">Car Types</label>
                                      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect1" v-model="car.car_type" required>
                                       
                                        <option value="0">Rent</option>
                                        <option value="1">Own</option>
                                      </select>
                                    </div>

                              <div v-if="this.car.car_type == 0" class="col-12">
                                    <div class="form-group">
                                      <input type="text" v-model="car.org_owner_name" class="form-control" placeholder="Please Fill Original Owner Name" aria-describedby="helpId">
                                    </div>
                                  
                                  <div class="d-md-flex mx-auto">
                                         <div class="form-group col-md-6 d-md-flex">
                                              <label for="contract_date" class="mx-4"> Contract Date</label>
                                              <date-picker v-model="car.contract_date" valueType="format" placeholder="choose date"></date-picker>
                                        </div>

                                        <div class="form-group col-md-6 d-md-flex">
                                              <label for="issue_date" class="mx-4"> Contract Renew Date</label>
                                               <date-picker v-model="car.renew_date" valueType="format" placeholder="choose date"></date-picker>
                                        </div>
                                  </div>
                                   

                                    <div class=" form-group mb-3">
                                      <label for="" class="form-label"> Upload Contract</label>
                                      <input type="file" class="form-control" @change="selectfile">
                                    </div> 

                                      
                                    <div class="form-group">
                                      <label for="" class="form-label"> Input Description</label>
                                      <textarea class="form-control" v-model="car.description" rows="3"></textarea>
                                    </div>

                              </div>

                                    <div class=" form-group mb-3">
                                      <label for="" class="form-label"> Upload Attach</label>
                                      <input type="file" class="form-control" @change="selectfiles" ref="files" multiple />
                                    </div> 
                                
                                <div class="d-flex flex-row-reverse">
                                  

                                    <button type="button" class="btn btn-danger mx-3" data-dismiss="modal">Close Box</button>
                                    <button type="submit" class="btn btn-success mx-3">Upload Data</button>
                               
                               </div>
                               


                            </form>
                         


                      
                        
                    </div>
                    </div>
                </div>
                </div>




                <div>
              
               
            </div>
  </div>
</template>

<script>

    //const DatePicker = require('vue2-datepicker')
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import moment from 'moment'

    export default {

        components: { DatePicker },
         data() {
            return {

                   success: false,

                   errors:{},

                    moment:moment,

                    lastMonth: moment().add(1, 'month').format("YYYY-MM-DD"),

                    openBox: false ,

                    cars:[],

                    car: {  
                        id:'',            
                        license_no: null,
                        brand: null,
                        model: null,
                        manufacture: null,
                        engine:null,
                        horsepower:null,
                        chassis:null,
                        kilometer: null,
                        upd_kilometer: null,
                        license_issue_date: '',
                        license_renew_date: '',
                        //status: null,
                        fuel_type: null,
                        seat: null,
                        purchase_value: null,
                        car_type: null,
                        contract_date: '',
                        org_owner_name: null,
                        renew_date: '',
                        contract: null,
                        attach:[],
                        description: null,
                    }
                
            };
            },

            methods: {

              openMe(){
                  this.openBox= true;
              },

                reset() {
                  this.car = {
                      license_no: null,
                        brand: null,
                        model: null,
                        manufacture: null,
                        engine:null,
                        horsepower:null,
                        chassis:null,
                        kilometer: null,
                        upd_kilometer: null,
                        license_issue_date: '',
                        license_renew_date: '',
                        //status: null,
                        fuel_type: null,
                        seat: null,
                        purchase_value: null,
                        car_type: null,
                        contract_date: '',
                        org_owner_name: null,
                        renew_date: '',
                        contract: null,
                        attach:[],
                        description: null,
                  }
                },

                close() {
                  this.openBox = false ;
                },

                view() {
                  axios.get("/api/car_data")
                  .then(response => {
                    this.cars = response.data.cars;
                  })
                  .catch ( err => console.log(err));
                },
 

                //for single file
                selectfile(event) {
                     this.car.contract = event.target.files[0];
                },

                //for multiple file
                selectfiles(){
                   
                  for (let i = 0; i < this.$refs.files.files.length ; i++) {
                    this.car.attach.push( this.$refs.files.files[i]);
                    
                    console.log(this.car.attach);
                  }
                  
                
                  
                },


               
                
                store(){

                  var self = this;

                 

                  const data = new FormData();
                  data.append('license_no' , this.car.license_no);
                  data.append('brand' , this.car.brand);
                  data.append('model', this.car.model);
                  data.append('manufacture', this.car.manufacture);
                  data.append('engine', this.car.engine);
                  data.append('horsepower', this.car.horsepower);
                  data.append('chassis', this.car.chassis);
                  data.append('kilometer', this.car.kilometer);
                  data.append('upd_kilometer', this.car.upd_kilometer);
                  data.append('license_issue_date', this.car.license_issue_date);
                  data.append('license_renew_date', this.car.license_renew_date);
                  //data.append('status', this.car.status);
                  data.append('fuel_type', this.car.fuel_type);
                  data.append('seat', this.car.seat);
                  data.append('purchase_value', this.car.purchase_value);
                  data.append('car_type', this.car.car_type);
                  data.append('contract_date', this.car.contract_date);
                  data.append('org_owner_name', this.car.org_owner_name);
                  data.append('renew_date', this.car.renew_date);
                  data.append('contract', this.car.contract);

                   for ( let i = 0 ; i < this.car.attach.length; i++) {
                    let file = self.car.attach[i];

                  data.append('attach[' + i + ']', file);
                  }

                
                  data.append('description', this.car.description);
                  
                  const config = {
                                      headers: {
                                          'content-type': 'multipart/form-data',
                                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                      }
                                  }

                    axios.post("/api/car_data" , data , config)
                               .then((response) => {
                                  this.reset();
                                  this.view();
                                  self.$refs.files.value ='';
                                  //$('#success').html(response.data.message);
                                  this.success = true ;
                                  console.log(response);
                                 
                                })
                              .catch(error => {
                                
                                     this.errors = error.response.data.errors;
                                
                               
                                  console.log("ERRRR:: ",error.response.data);
                                  
                                  });   
                                  },

                  destroy(id){
                      if(!confirm ('Are You Sure To Delete')) return ;
                      axios.delete(`/api/car_data/${id}`)
                      .then((response) => {
                        this.view();
                      })
                  }

            },

            created(){
              this.view();
            },

            mounted() {
                console.log('Component mounted.')
            }
    }
</script>