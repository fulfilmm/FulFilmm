<template>
      
      <div class=" container">
              <div class=" container-fluid rounded shadow-md bg-light px-3 py-4 my-2">
                <div class="text-gray font-bold text-center h3 ">
                    Maintainance Data
                </div>

                    <div>
                        <a :href="`/maintainance`" class="text-white text-decoration-none bg-secondary px-3 py-2 my-2 rounded"> <font-awesome-icon icon="backward" /> Back </a>
                    </div>
                 </div>

                 <form @submit.prevent="updateForm">

                   <div class=" d-flex flex-row-reverse">
                                <div>
                                    
                                </div>
                                  <button type="button" class="btn btn-success mx-2" @click="edit" v-if="! this.editForm"> <font-awesome-icon icon="pen-to-square" /> </button>
                            
                                  <button type="submit" class=" btn btn-white text-info px-3 mx-2" v-if="this.editForm"> <font-awesome-icon icon="fa-file-arrow-up" /> </button>
                                  <button type="button" class=" btn btn-danger mx-2" @click="close" v-if="this.editForm"> <font-awesome-icon icon=" fa-xmark" /> </button>
                   </div>
                  
                  <div class=" p-3 m-3 rounded-lg text-gray bg-white shadow-md">


                      <div class="row py-2 my-2 border-bottom">
                        <div class="col">
                            Licanse Number
                        </div>

                
                    
                            <div class="col">
                                <p v-for="c in car" :key="c.id"> {{ c.license_no}} </p>                                   
                            </div>

                    </div>

                      <div class="row my-2 py-2 border-bottom">
                            <div class="col">
                                Status
                            </div>
                            <div class="col">
                                <div v-if=" ! this.editForm">
                                    <p v-if="maintain.status == 0"> Maintain </p>
                                    <p v-if="maintain.status == 1"> Repair </p>
                                </div>

                                <div v-if=" this.editForm">
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.status">
                                        
                                        
                                            <option value="0">Maintain</option>
                                            <option value="1">Repair</option>
                                    </select>
                                </div>
                            

                            </div>

                      </div>

                       <div class="row py-2 my-2 border-bottom">
                            <div class="col">
                                Kilometer
                            </div>

                    
                        
                                <div class="col">
                                    <p v-if=" !this.editForm"> {{ maintain.kilometer}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="maintain.kilometer" v-if="this.editForm">
                                </div>

                        </div>

                         <div class="row py-2 my-2 border-bottom">
                                <div class="col">
                                    Workshop
                                </div>

                        
                            
                                    <div class="col">
                                        <p v-if=" !this.editForm"> {{ maintain.workshop}} </p>
                                            <input type="text" class=" form-control shadow-md" v-model="maintain.workshop" v-if="this.editForm">
                                    </div>

                            </div>

                         <div class="row py-2 my-2 border-bottom">
                                <div class="col">
                                    Case
                                </div>
                                  <div class="col">
                                        <p v-if=" !this.editForm"> {{ maintain.case}} </p>
                                            <input type="text" class=" form-control shadow-md" v-model="maintain.case" v-if="this.editForm">
                                    </div>

                            </div>

                             <div class="row my-2 py-2 border-bottom">
                                    <div class="col">
                                        Service Date
                                    </div>
                                    <div class="col">
                                            <p v-if="! this.editForm"> {{ moment( maintain.service_date ).format("MMM Do YYYY") }} </p>
                                            <date-picker v-model="maintain.service_date" valueType="format" placeholder="choose date" v-if="this.editForm"></date-picker>   
                                    </div>

                                </div>

                            
                             <div class="row py-2 my-2 border-bottom">
                                <div class="col">
                                    Driver
                                </div>
                                  <div class="col">
                                        <div v-if=" !this.editForm">
                                             <p v-if="maintain.driver == 0"> U Ba </p>
                                             <p v-if="maintain.driver == 1"> U Mya </p>
                                             <p v-if="maintain.driver == 2"> U Hla </p>
                                        </div>
                                         
                                         <div v-if="this.editForm">
                                              <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="maintain.driver">
                                    
                                                <option value="0">U Ba</option>
                                                <option value="1">U Mya</option>
                                                <option value="2">U Hla</option>
                                            </select>
                                         </div>
                                    </div>

                            </div>

                             <div class="row my-2 py-2 border-bottom">
                                <div class="col">
                                    Attach
                                </div>
                                <div class="col">
                                    <p v-for="data  in maintain.attaches" :key="data" class= "text-small">
                                        <a :href="`/download/maintain/attaches/`+data"> {{ data }} </a>
                                    </p>
                                </div>

                            </div>


                            

                             <div class="row my-2 py-2 border-bottom">
                                    <div class="col">
                                        Description
                                    </div>
                                    <div class="col">
                                        {{ maintain.description}}
                                    </div>

                                </div>

                </div>

                 </form>
 
      </div>


       


</template>
  
 <script>

import moment from 'moment';
import DatePicker from 'vue2-datepicker';

 export default {

     components: {DatePicker},
    
    data() {
        return {

            editForm: false,

            moment: moment,

            maintain:{},

            car:{},
        }
    },

    methods: {
         edit(){
            this.editForm = true ;
        },

        close() {
            this.editForm = false ;
        },

         updateForm() {
            axios.patch(`/api/maintainance/${this.$route.params.id}` , this.maintain)
            .then(response => {
                this.close();
                console.log(response);
            })

             .catch ( err => console.log(err));

        },
    },

    created() {
        axios.get(`/api/maintainance/${this.$route.params.id}`)
        .then(response => {
            this.maintain = response.data.maintain;
            this.car = response.data.car;
        })
    }
 }
 </script>