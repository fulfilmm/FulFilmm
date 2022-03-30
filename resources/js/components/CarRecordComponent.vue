<template>
    <div>
            <div class="row border-bottom">
                <div class="col text-secondary p-3 m-3">
                    <p> License Number - {{car.license_no}}</p>
                    <p> Model - {{ car.model}}  </p>
                    <p> Engine Power - {{car.engine}}</p>
                </div>
                <div class="col my-auto text-right mr-3">
                
                 <div class="my-2">
                    <router-link :to="`/car-list`" class="text-white bg-secondary px-3 py-2 my-2 rounded-pill text-decoration-none"> <font-awesome-icon icon="backward" /> Back </router-link>
                </div>
                 <button type="button" class="btn btn-primary rounded-pill shadow-lg px-3 mb-5" data-toggle="modal" data-target=".bd-example-modal-xl">
                    Upload Schedule
                </button>
                
                </div>
            </div>

            <div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Need To Check</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Done</button>
                          
                        </div>
                        </nav>
                    <div class="tab-content" id="nav-tabContent">

                        <!----------- for Need To Check ----------->
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            
                                    <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col"> Cases</th>
                                        <th scope="col"> WorkShop</th>
                                        <th scope="col"> Kilometer </th>
                                        <th scope="col"> Date </th>
                                        <!-- <th scope="col"> Driver </th>
                                        <th scope="col"> Total </th> -->
                                        <th scope="col"> datail </th>
                                        <th scope="col"> delete</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody  v-for="car in car.routines" :key="car.id">
                                        <tr v-if="car.check == 0">
                                           

                                        <td>
                                            <small class=" font-weight-bold" v-for="c in JSON.parse(car.case)" :key="c.id"> 
                                                {{ c.case}}   
                                            </small>
                                                
                                            
                                        </td>
                                        <td> {{car.workshop}}</td>
                                        <td> {{car.kilometer}}</td>
                                        <td> {{ moment( car.created_at ).format("MMM Do YYYY") }}</td>
                                        <!-- <td>
                                            <div>
                                                <p v-if="car.driver == 0"> U Ba </p>
                                                <p v-if="car.driver == 1"> U Mya </p>
                                                <p v-if="car.driver == 2"> U Hla </p>
                                            </div>
                                        </td>
                                        <td>{{car.total}}</td> -->
                                        
                                        
                                        
                                        <td> <router-link :to="`/car-list/car-record/detail/${car.id}`"  class=" btn btn-info rounded-pill text-white"> <font-awesome-icon icon="fa-circle-info" /> </router-link> </td>

                                        <td>
                                            <button type="button" class="btn btn-danger rounded-pill" @click="destroy(car.id)"> <font-awesome-icon icon="fa-trash-can" />  </button>
                                        </td>
                                      
                                        </tr>
                                        
                                    </tbody>
                                    </table>
                               
                         </div>


                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                              
                                    <table class="table table-striped" >
                                    <thead>
                                        <tr>
                                        <th scope="col"> Cases</th>
                                        <th scope="col"> WorkShop</th>
                                        <th scope="col"> Kilometer </th>
                                        <th scope="col"> Date </th>
                                        <!-- <th scope="col"> Driver </th>
                                        <th scope="col"> Total </th> -->
                                        <th scope="col"> datail </th>
                                        <th scope="col"> delete</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody v-for="car in car.routines" :key="car.id">
                                        <tr v-if="car.check == 1">
                                         

                                        <td>
                                            <small class=" font-weight-bold" v-for="c in JSON.parse(car.case)" :key="c.id"> 
                                                {{ c.case}}   
                                            </small>
                                                
                                            
                                        </td>
                                        <td> {{car.workshop}}</td>
                                        <td> {{car.kilometer}}</td>
                                        <td> {{ moment( car.created_at ).format("MMM Do YYYY") }}</td>
                                        <!-- <td>
                                            <div>
                                                <p v-if="car.driver == 0"> U Ba </p>
                                                <p v-if="car.driver == 1"> U Mya </p>
                                                <p v-if="car.driver == 2"> U Hla </p>
                                            </div>
                                        </td>
                                        <td>{{car.total}}</td> -->
                                        
                                        
                                        
                                        <td> <router-link :to="`/car-list/car-record/detail/${car.id}`"  class=" btn btn-info rounded-pill text-white"> <font-awesome-icon icon="fa-circle-info" /> </router-link> </td>

                                        <td>
                                            <button type="button" class="btn btn-danger rounded-pill" @click="destroy(car.id)"> <font-awesome-icon icon="fa-trash-can" />  </button>
                                        </td>
                                         
                                        </tr>
                                        
                                    </tbody>
                                    </table>
                              

                        </div>
                        
                    </div>

            </div>

             






              <!------------------------------------ upload record  ------------------------------------------------->
              <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-body">
                          <form @submit.prevent="store" class="row">
                                
                                 <div class="alert alert-success" v-show="success"> Data Created Successfully</div>

                 

                        

                                  

                                
                                <!----------------------------------- for case array ------------------------------------------>

                               
                               <div class=" p-2 my-2 mx-0 rounded bg-light">

                                    <form @submit.prevent="cases">
                                    
                                        <div>
                                            <h4 class="">Input Case Records </h4>

                                            <div class="row">
                                                 <div class="forn-group col mx-2">
                                                        <input type="text" class="form-control rounded" placeholder="Input Case" v-model="form.case">
                                                </div>

                                                <!-- <div class=" form-group col mx-2">
                                                        <input type="text" class="form-control rounded" placeholder="Input Expense" v-model="form.expense">
                                                </div> -->
                                            </div>
                                           
                                           <div class="row">
                                                <div class="col">
                                                    <label for="issue_date" class="mx-4"> Start Date</label>
                                                    <date-picker v-model="form.start_date" valueType="format" placeholder="choose date"></date-picker>
                                                </div>

                                                 <div class="col">
                                                    <label for="issue_date" class="mx-4"> Expire Date</label>
                                                    <date-picker v-model="form.end_date" valueType="format" placeholder="choose date"></date-picker>
                                                </div>
                                           </div>
                                             

                                            <div class="my-2">
                                                <button class="btn btn-success" type="submit"> Add Me </button>
                                            </div>
                                        </div>

                                    </form>

                                    <div>
                                        <table class="table p-3">
                                            <thead>
                                                <tr>
                                                    <th> Case </th>
                                                    <!-- <th> Expanse </th> -->
                                                    <th> state_date</th>
                                                    <th> end_date</th>
                                                    <th> Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(c, index) in routine.records" :key="c.id">
                                                    <td scope="row"> {{c.case}}</td>
                                                    <!-- <td> {{c.expense}}</td> -->
                                                    <td>{{c.start_date}}</td>
                                                    <td>{{c.end_date}}</td>
                                                    <td><button class="btn btn-danger" @click="deleteCases(index)"> Delete</button> </td>
                                                </tr>
                                                <!-- <tr>
                                                  
                                                    <td colspan="3"> total </td>
                                                    <td>{{totalAmt}}</td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                  

                               </div>
                                    
                                
                              

                                <!---------------------------------------------------------------------------------------------->

                               

                                <div class=" form-group col-md-6 col-sm-12">
                                      <input type="text"  v-model="routine.kilometer" class="form-control" placeholder="Please Fill Current Kilometer" aria-describedby="helpId">
                                       <!-- <span class="text-small text-danger" v-if="errors && errors.kilometer">
                                          {{ errors.kilometer[0] }}
                                      </span> -->
                                </div>

                                <div class=" form-group col-md-6 col-sm-12">
                                      <input type="text"  v-model="routine.workshop" class="form-control" placeholder="Please Fill Workshop Name" aria-describedby="helpId">
                                       <!-- <span class="text-small text-danger" v-if="errors && errors.workshop">
                                          {{ errors.workshop[0] }}
                                      </span> -->
                                </div>

                                 

                                <div class="form-group col-md-6 col-sm-12">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Select Driver</label>
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="routine.driver">
                                    
                                        <option value="0">U Ba</option>
                                        <option value="1">U Mya</option>
                                        <option value="2">U Hla</option>
                                    </select>
                                         <!-- <span class="text-small text-danger" v-if="errors && errors.driver">
                                          {{ errors.driver[0] }}
                                      </span> -->
                                </div>

                                 <div class=" form-group mb-3">
                                      <label for="" class="form-label"> Upload Attach</label>
                                      <input type="file" class="form-control"  @change="selectfiles" ref="files" multiple />

                                       <!-- <span class="text-small text-danger" v-if="errors && errors.attaches">
                                          {{ errors.attaches[0] }}
                                      </span> -->
                                </div> 

                                 <div class="form-group">
                                      <label for="" class="form-label"> Add Note</label>
                                      <textarea class="form-control" v-model="routine.note" rows="3"></textarea>
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
       
    </div>
</template>

<script>

import moment from 'moment';
import DatePicker from 'vue2-datepicker';

export default {
    components: {DatePicker},
    
    data() {
        return {
            moment: moment,

            car:{},

            errors:{},

            editForm: false,

            success: false,

            //content = JSON.parse(this.car.routines.case),

            routine: {
                car_id:this.$route.params.id,
                records:[],
                driver:'',
                workshop:'',
                attaches:[],
                kilometer:'',
                note:'',
            },

            form: {
                case:'',
                start_date:'',
                end_date:'',
                //expense:'',
            },

           
        }
    },

    methods: {

        reset(){
            this.routine = {
                car_id:this.$route.params.id,
                records:[],
                driver:'',
                workshop:'',
                attaches:[],
                kilometer:'',
                note:'',
            }
        },

        //for cases array

        cases(){
            const data = {
                case : this.form.case,
                start_date: this.form.start_date,
                end_date: this.form.end_date,
                //expense: this.form.expense,
            }

            this.routine.records.push(data);
            this.form = [];
        },

        deleteCases(index){
            this.routine.records.splice(index);
        },
        
        //end

        view(){
            axios.get(`/api/car_data/${this.$route.params.id}`)
                .then((response) => {
                    this.car = response.data;
                })
                .catch(err => console.log(err));      
        },

        //post data
        selectfiles(){
            for( let i = 0; i < this.$refs.files.files.length; i++){
                this.routine.attaches.push(this.$refs.files.files[i]);

                console.log(this.routine.attaches);
            }
        },

        store(){
            var self = this;

            let cases = JSON.stringify(this.routine.records);

             const data = new FormData();

            data.append('car_id' , this.routine.car_id);
            data.append('case' , cases);
            data.append('driver', this.routine.driver);
            data.append('workshop', this.routine.workshop);
            
            for( let i = 0 ; i < this.routine.attaches.length; i++){
                let file = self.routine.attaches[i];
            
            data.append('attaches['+i+']', file);
            }
           //data.append('total', this.totalAmt);
         
           data.append('kilometer' , this.routine.kilometer);
           data.append('note', this.routine.note);

            const config = {
                header: {
                    'content-type' : 'multipart/from-data',
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }

            axios.post("/api/maintain_check" , data, config)
                    .then((response) =>  {
                        this.reset();
                        this.view();
                        self.$refs.files.value ='';
                    })
                    .catch( error => {
                         console.log("ERRRR:: ",error.response.data);
                    })
                   
                   
        },

        destroy(id){
            if(!confirm('Are You Sure To Delete')) return;
            axios.delete(`/api/maintain_check/${id}`)
                    .then(response => {
                        this.view();
                    })
        }
    },

    created() {
        this.view();
    },

    // computed:{
    //     totalAmt(){
    //         if(! this.routine.records){
    //             return 0;
    //         }

    //         return this.routine.records.reduce( function(totalAmt, records){
                
    //             return totalAmt + Number(records.expense);
    //         },0);
    //     }
    // }
}
</script>

