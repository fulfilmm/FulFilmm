<template>
    <div class="container-fluid">
        <div class=" d-flex flex-row-reverse mt-3">
                <button type="button" class="btn btn-primary rounded-pill shadow-lg px-3 mb-5" data-toggle="modal" data-target=".bd-example-modal-xl">
                    Upload Maintainance Record
                </button>
            </div>


             <div class=" container-fluid my-4">
                <table class="table table-striped">
                  <thead>
                    <tr>
                   
                      <th scope="col"> License Number</th>
                      <th scope="col"> Status </th>
                      <th scope="col"> Kilometer </th>
                      <th scope="col"> Workshop </th>
                      <th scope="col"> Case  </th>
                      <th scope="col"> Detail</th>
                      <th scope="col"> Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="maintain in maintains" :key="maintain.id">
                      
                      <td> {{maintain.car.license_no}}</td>

                      <td> 
                        
                        <div  v-if="maintain.status == 0" class="text-warning"> Maintain </div>
                        <div  v-else-if="maintain.status == 1" class="text-danger"> Repair </div>
                      </td>

                       <td> {{maintain.kilometer}}</td>
                       <td> {{maintain.workshop}}</td>
                       <td> {{maintain.case}}</td>

                     

                      
                      <td> 
                         <a :href="`/maintain/${maintain.id}`"  class=" btn btn-info shodow-md px-3 border-none rounded-pill text-white"> Detail </a> 
                      </td>

                      <td>
                        <button type="button" class="btn btn-danger rounded-pill" @click="destroy(maintain.id)"> Delete </button>
                      </td>
                    
                    </tr>
                    
                  </tbody>
                </table>
            </div>
      




             <!------------------------------------ upload record  ------------------------------------------------->
              <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-body">
                          <form @submit.prevent="store" class="row">
                                
                                 <div class="alert alert-success" v-show="success"> Data Created Successfully</div>


                                <div class="form-group col-md-6 col-sm-12">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Select Car</label>
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.car_id">
                                        <option  v-for=" car in cars" :key="car.id" :value="car.id">{{car.license_no}}</option>
                                    </select>

                                     <span class="text-small text-danger" v-if="errors && errors.car_id">
                                          {{ errors.car_id[0] }}
                                      </span>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Add Car Status</label>
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.status">
                                    
                                        <option value="0">Maintain</option>
                                        <option value="1">Repair</option>
                                    </select>

                                     <span class="text-small text-danger" v-if="errors && errors.status">
                                          {{ errors.status[0] }}
                                      </span>
                                </div>

                                  

                                

                                <div class=" form-group">
                                      <input type="text"  v-model="maintain.case" class="form-control" placeholder="Please Fill Case" aria-describedby="helpId">

                                      <span class="text-small text-danger" v-if="errors && errors.case">
                                          {{ errors.case[0] }}
                                      </span>
                                
                                </div>

                                <div class="form-group">
                                      <label for="" class="form-label"> Input Description</label>
                                      <textarea class="form-control" v-model="maintain.description" rows="3"></textarea>
                                </div>

                                <div class=" form-group col-md-6 col-sm-12">
                                      <input type="text"  v-model="maintain.kilometer" class="form-control" placeholder="Please Fill Current Kilometer" aria-describedby="helpId">
                                       <span class="text-small text-danger" v-if="errors && errors.kilometer">
                                          {{ errors.kilometer[0] }}
                                      </span>
                                </div>

                                <div class=" form-group col-md-6 col-sm-12">
                                      <input type="text"  v-model="maintain.workshop" class="form-control" placeholder="Please Fill Workshop Name" aria-describedby="helpId">
                                       <span class="text-small text-danger" v-if="errors && errors.workshop">
                                          {{ errors.workshop[0] }}
                                      </span>
                                </div>

                                 <div class="form-group col-md-6 d-md-flex">

                                            <div>
                                              <label for="issue_date" class="mx-4"> Service Date</label>
                                               <date-picker v-model="maintain.service_date" valueType="format" placeholder="choose date"></date-picker>
                                            </div>
                                               
                                            <div class="text-small text-danger" v-if="errors && errors.service_date">
                                                  {{ errors.service_date[0] }}
                                              </div>
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                  <label class="mr-sm-2" for="inlineFormCustomSelect0">Please Select Driver</label>
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.driver">
                                    
                                        <option value="0">U Ba</option>
                                        <option value="1">U Mya</option>
                                        <option value="2">U Hla</option>
                                    </select>
                                         <span class="text-small text-danger" v-if="errors && errors.driver">
                                          {{ errors.driver[0] }}
                                      </span>
                                </div>

                                 <div class=" form-group mb-3">
                                      <label for="" class="form-label"> Upload Attach</label>
                                      <input type="file" class="form-control"  @change="selectfiles" ref="files" multiple />

                                       <span class="text-small text-danger" v-if="errors && errors.attaches">
                                          {{ errors.attaches[0] }}
                                      </span>
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

 import DatePicker from 'vue2-datepicker';

    export default {

       components: { DatePicker },
       
       data() {
           return {
               success: false,

               cars: [],

               maintains:[],

               errors:{},

               maintain: {
                   status:'',
                   car_id:'',
                   case:'',
                   description:'',
                   kilometer:'',
                   workshop:'',
                   service_date:'',
                   driver:'',
                   attaches:[],
               }
           }
       },



       methods: {

           reset() {
               this.maintain = {
                    status:'',
                   car_id:'',
                   case:'',
                   description:'',
                   kilometer:'',
                   workshop:'',
                   service_date:'',
                   driver:'',
                   attaches:[],
               }
           },

           view() {
               axios.get('/api/maintainance')
               .then(response => {
                   this.cars = response.data.cars;
                   this.maintains = response.data.maintains;
               })
               .catch ( err => console.log(err));
           },


           //for store method

           selectfiles(){
               for (let i = 0; i < this.$refs.files.files.length; i++) {
                   this.maintain.attaches.push(this.$refs.files.files[i]);

                   console.log(this.maintain.attaches);
               }
           },

           store() {

               var self = this;

               const data = new FormData();

               data.append('status', this.maintain.status);
               data.append('car_id', this.maintain.car_id);
               data.append('case', this.maintain.case);
               data.append('description', this.maintain.description);
               data.append('kilometer', this.maintain.kilometer);
               data.append('workshop', this.maintain.workshop);
               data.append('service_date', this.maintain.service_date);
               data.append('driver', this.maintain.driver);

               for ( let i = 0 ; i < this.maintain.attaches.length; i++) {
                   let file = self.maintain.attaches[i];
                
               data.append('attaches[' + i + ']', file);
               }

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
                                self.$refs.files.value='';
                                this.success = true;
                                this.errors = {};
                                console.log(response);
                            })
                            .catch( error => {
                                  if (error.response.status == 422) {
                                          this.errors = error.response.data.errors;
                                      }
                                      console.log(error);
                               
                            })
           },

            destroy(id){
                      if(!confirm ('Are You Sure To Delete')) return ;
                      axios.delete(`/api/maintainance/${id}`)
                      .then((response) => {
                        this.view();
                      })
                  }

        
       },

       created() {
            this.view();
        }
    }
</script>
