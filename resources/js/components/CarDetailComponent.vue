<template>
    <div class="container">

        <div class=" container-fluid rounded shadow-md bg-light px-3 py-4 my-2">
            <div class="font-bold text-center h3 text-gray ">
                Car Data Detail
            </div>

            <div>
                <a :href="`/car-list`" class="text-white bg-secondary px-3 py-2 my-2 rounded text-decoration-none"> <font-awesome-icon icon="backward" /> Back </a>
            </div>

              <form @submit.prevent="updateData">

                   <div class=" d-flex flex-row-reverse">
                                <div>
                                    
                                </div>
                                  <button type="button" class="btn btn-success mx-2" @click="edit" v-if="! this.editForm"> <font-awesome-icon icon="pen-to-square" /> </button>
                            
                                  <button type="submit" class=" btn btn-white text-info px-3 mx-2" v-if="this.editForm"> <font-awesome-icon icon="fa-file-arrow-up" /> </button>
                                  <button type="button" class=" btn btn-danger mx-2" @click="close" v-if="this.editForm"> <font-awesome-icon icon=" fa-xmark" /> </button>
                   </div>

            <div class=" p-3 m-3 rounded-lg text-gray bg-white shadow-md">

                <!----------  for License No ------------>
                <div class="row py-2 my-2 border-bottom">
                    <div class="col">
                        Licanse Number
                    </div>

              
                
                          <div class="col">
                               <p v-if=" !this.editForm"> {{ car.license_no}} </p>
                                <input type="text" class=" form-control shadow-md" v-model="car.license_no" v-if="this.editForm">
                          </div>

                </div>
                <!------------------ end ---------------------->



                <!---------------- for car Brand -------------->


                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Car Brand
                    </div>
                    <div class="col">
                    
                         <p v-if=" !this.editForm"> {{ car.brand}} </p> 
                          <input type="text" class=" form-control shadow-md" v-model="car.brand" v-if="this.editForm">
                    </div>

                </div>

                <!-------------- end ------------------->


                <!-------------- for model -------------->
                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Car Model
                    </div>
                    <div class="col">
                        <p v-if=" !this.editForm">   {{ car.model}} </p> 
                         <input type="text" class=" form-control shadow-md" v-model="car.model" v-if="this.editForm">
                      
                    </div>

                </div>

                <!------------------ end ------------------>


                <!------------------ for manufacture -------------->

                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Manufacture Company
                    </div>
                    <div class="col">
                         <p v-if=" !this.editForm">    {{ car.manufacture}} </p> 
                         <input type="text" class=" form-control shadow-md" v-model="car.manufacture" v-if="this.editForm">
                    </div>

                </div>

                <!--------------------- end ----------------------->


                <!------------------ engin power ------------------>

                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Engine Power
                    </div>
                    <div class="col">
                        <p v-if=" !this.editForm">    {{ car.engine}}</p> 
                        <input type="text" class=" form-control shadow-md" v-model=" car.engine" v-if="this.editForm">
                    </div>

                </div>

                <!-------------------end --------------------------->


                <!-------------------- horse power ----------------->
                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Horse Power
                    </div>
                    <div class="col">
                         <p v-if=" !this.editForm">    {{ car.horsepower}}</p> 
                        <input type="text" class=" form-control shadow-md" v-model=" car.horsepower" v-if="this.editForm">
                    </div>

                </div>

                <!-----------------------end ----------------------->



                <!------------------------ chassis ----------------->

                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Chassis
                    </div>
                    <div class="col">
                        <p v-if=" !this.editForm">   {{ car.chassis}}</p> 
                         <input type="text" class=" form-control shadow-md" v-model="car.chassis" v-if="this.editForm">

                    </div>

                </div>

                <!----------------------- end ------------------------->


                <!------------------------ Org kilometer ------------------>

                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Original Kilometer
                    </div>
                    <div class="col"> 
                        {{ car.kilometer}}
                    </div>

                </div>

                <!------------------ end ------------------------------>

                <!----------------------- current kilo --------------------->

                <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Current Kilometer
                    </div>
                    <div class="col">
                         <p v-if=" !this.editForm">   {{ car.upd_kilometer}}</p> 
                         <input type="text" class=" form-control shadow-md" v-model="car.upd_kilometer" v-if="this.editForm">
                    </div>

                </div>

                <!------------------------ end ------------------------------->

                <!----------------------- license issue --------------------->

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        License Issue Date
                    </div>
                    <div class="col">
                            <p v-if="! this.editForm"> {{ moment( car.license_issue_date ).format("MMM Do YYYY") }} </p>
                             <date-picker v-model="car.license_issue_date" valueType="format" placeholder="choose date" v-if="this.editForm"></date-picker>
                       
                    </div>

                </div>

                <!--------------------- end ---------------------->


                <!------------------------- license renew --------------->

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        License Renew Date
                    </div>
                    <div class="col">
                         <p v-if="! this.editForm"> {{ moment( car.license_renew_date ).format("MMM Do YYYY") }} </p>
                         <date-picker v-model="car.license_renew_date" valueType="format" placeholder="choose date" v-if="this.editForm"></date-picker>
                    </div>

                </div>

                <!------------------------- end ------------------------------>



                <!------------------  status ------------------------->           

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Status
                    </div>
                    <div class="col">
                         <!-- <div v-if="! car.status.length" class=" text-success"> Working</div> -->
                            
                            <div>
                                 <div v-for="s in car.status" :key="s.id">
                                    <div  v-if="s.status == 0" class="badge badge-warning"> Maintain </div>
                                    <div  v-else-if="s.status == 1" class="badge badge-danger" > Repair </div>
                                </div>
                            </div>

                    </div>

                </div>

                <!----------------------- end --------------------------->


                <!---------------------- fuel ----------------------------->

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Fuel Type
                    </div>
                    <div class="col">
                        <div v-if=" ! this.editForm">
                            <p v-if="car.fuel_type == 0"> Petro </p>
                            <p v-if="car.fuel_type == 1"> Disel </p>
                        </div>
                        <div v-if=" this.editForm">
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="car.fuel_type">
                                  
                                    <option value="0">Petro</option>
                                    <option value="1">Diesel</option>
                            </select>
                        </div>
                        
                    </div>
                </div>


                <!--------------------------- end --------------------------->


                <!------------------------------ seat --------------------------->

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Seat
                    </div>
                    <div class="col">
                         <p v-if=" !this.editForm">   {{ car.seat}}</p> 
                         <input type="text" class=" form-control shadow-md" v-model="car.seat" v-if="this.editForm">
                         
                    </div>

                </div>

                <!------------------------------------ end ------------------------------------>


                <!------------------------------ purchase ---------------------------------------->

                 <div class="row  my-2 py-2 border-bottom">
                    <div class="col">
                        Purchase Value
                    </div>
                    <div class="col">
                         <p v-if="! this.editForm"> {{ car.purchase_value}} </p>
                        <input type="text" class=" form-control shadow-md" v-model="car.purchase_value" v-if="this.editForm">
                    </div>

                </div>

                <!------------------------------------- end -------------------------------------->

                <!----------------------------------- type ----------------------------------->

                 <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Type
                    </div>
                    <div class="col">
                        <p v-if="car.car_type == 0"> Rent </p>
                        <p v-if="car.car_type == 1"> Own </p>
                    </div>
                </div>

                <!-------------------------------------- end ---------------------------------->

                <!------ check statement for owner or rent -------->

                <div v-if="car.car_type == 0">

               

                <!---------- org owner -------->
                      <div class="row my-2 py-2 border-bottom">
                        <div class="col">
                            Original Owner
                        </div>
                        <div class="col">
                             <p v-if="! this.editForm"> {{ car.org_owner_name}} </p>
                             <input type="text" class=" form-control shadow-md" v-model="car.org_owner_name" v-if="this.editForm">
                        </div>

                    </div>
                <!------------- end ------------------>

                <!-------------- contract Date ---------------->

                      <div class="row my-2 py-2 border-bottom">
                        <div class="col">
                            Contract Date
                        </div>
                        <div class="col">
                             <p v-if="! this.editForm"> {{ moment( car.contract_date ).format("MMM Do YYYY") }} </p>
                              <date-picker v-model="car.contract_date" valueType="format" placeholder="choose date" v-if="this.editForm"></date-picker>
                            
                        </div>

                    </div>
                
                <!------------------- end ------------------------>


                <!----------------- contract renew ------------->

                      <div class="row my-2 py-2 border-bottom">
                            <div class="col">
                                Contract Renew Date
                            </div>
                            <div class="col">
                                <p v-if="! this.editForm"> {{ moment( car.renew_date ).format("MMM Do YYYY") }} </p>
                                 <date-picker v-model="car.renew_date" valueType="format" placeholder="choose date" v-if="this.editForm"></date-picker>
                                 
                            </div>

                        </div>
                <!---------------- end ------------------------>

                <!------------------ contract ------------------>
                          <div class="row my-2 py-2 border-bottom">
                            <div class="col">
                                Contract
                            </div>
                            <div class="col">
                                <a :href="`/download/`+car.contract"> {{ car.contract}} </a>
                            </div>
                          </div>
                <!----------------- end ------------------------>

                <!------------------- description ---------------->

                          <div class="row my-2 py-2 border-bottom">
                            <div class="col">
                                Description
                            </div>
                            <div class="col">
                                {{ car.description}}
                            </div>

                        </div>
                <!--------------------- end --------------------->

                </div>

                <!--------------- if statement end ----------------->

                <!----------------------- for attach file ------------------>

                  <div class="row my-2 py-2 border-bottom">
                    <div class="col">
                        Attach
                    </div>
                    <div class="col">
                         <p v-for="data  in car.attach" :key="data" class= "text-small">
                              <a :href="`/download/car-list/attach/`+data"> {{ data }} </a>
                         </p>
                    </div>

                </div>

                <!----------------------- end ------------------------>


                
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

    components: { DatePicker },

    data() {
        return {
            editForm: false,
            moment: moment,
            

            car:{}
        }
    },

    methods: {
        edit() {
            this.editForm = true ;
        },

        close() {
            this.editForm = false ;
        },

        updateData() {
            axios.patch(`/api/car_data/${this.$route.params.id}` , this.car)
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
