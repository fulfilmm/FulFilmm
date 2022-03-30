<template>
    <div class="container">
          <div class=" container-fluid rounded shadow-md bg-light px-3 py-4 my-2">
                <div class="text-gray font-bold text-center h3 ">
                    Schedule
                </div>

                    <div>
                        <router-link :to="`/car-list/car-record/`+ record.car_id" class="text-white text-decoration-none bg-secondary px-3 py-2 my-2 rounded"> <font-awesome-icon icon="backward" /> Back </router-link>
                    </div>
            </div>


              <form @submit.prevent="updateForm">

                   <div class=" d-flex flex-row-reverse">
                       
                                            <button type="button" class="btn btn-success mx-2" @click="edit" v-if="! this.editForm"> <font-awesome-icon icon="pen-to-square" /> </button>
                                        
                                            <button type="submit" class=" btn btn-white text-info px-3 mx-2" v-if="this.editForm"> <font-awesome-icon icon="fa-file-arrow-up" /> </button>
                                            <button type="button" class=" btn btn-danger mx-2" @click="close" v-if="this.editForm"> <font-awesome-icon icon=" fa-xmark" /> </button>
                    </div>

                     <div class="row my-2 py-2 border-bottom">
                            <div class="col h3 font-weight-bold">
                                Current-Infomation
                            </div>
                            <div class="col">
                                <div v-if=" ! this.editForm">
                                    <p v-if="record.check == 0" class=" h3 text-danger"> Pending </p>
                                    <p v-if="record.check == 1" class=" h3 text-success"> Done </p>
                                </div>

                                <div v-if=" this.editForm">
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="record.check">
                                        
                                        
                                            <option value="0">Pending</option>
                                            <option value="1">Done</option>
                                    </select>
                                </div>
                            

                            </div>

                      </div>

                    <div class=" p-3 m-3 rounded-lg text-gray bg-light shadow-md">
                            
                        
                            <div class="row my-2 py-2 border-bottom">
                                    <div class="col h3 font-weight-bold">
                                    Cases Record
                                    </div>
                                <table class="table p-3 text-center">
                                    <thead>
                                        <tr class=" bg-light ">
                                            <th> Case </th>
                                            <!-- <th> Expanse </th> -->
                                            <th> Start Date</th>
                                            <th> Expire Date </th>
                                        </tr>
                                    </thead>
                                    <tbody class=" font-weight-bold">
                                        <tr v-for="c in record.case" :key="c.id">
                                            <td scope="row"> {{c.case}}</td>
                                            <!-- <td> {{c.expense}}</td> -->
                                            <td>{{c.start_date}}</td>
                                            <td>
                                                <p v-if="c.end_date <= lastMonth" class="text-danger"> {{c.end_date}} </p>
                                                <p v-else>  {{c.end_date}} </p>
                                            </td>
                                        </tr>
                                        <!-- <tr class=" font-weight-bold h5">
                                            <td colspan="2" class="text-right"> Total </td>
                                            <td scope="row"> {{record.total}}</td>
                                            
                                        </tr> -->
                                    </tbody>
                                </table>
                                

                            </div>
                            
                            <div class=" my-3 bg-white">
                            <div  class="row my-2 py-2 border-bottom">
                                <div class="col font-weight-bold">
                                    Workshop
                                    </div>
                                    <div class="col">
                                       <p v-if=" ! this.editForm"> {{record.workshop}} </p>
                                         <input type="text" class=" form-control shadow-md" v-model="record.workshop" v-if="this.editForm">
                                    </div>
                            </div>
                            <div  class="row my-2 py-2 border-bottom">
                                <div class="col font-weight-bold">
                                    Kilometer
                                    </div>
                                    <div class="col">
                                        <p v-if=" ! this.editForm"> {{record.kilometer}} </p>
                                        <input type="text" class=" form-control shadow-md" v-model="record.kilometer" v-if="this.editForm">
                                    </div>
                            </div>
                            
                            <div class="row py-2 my-2 border-bottom">
                                        <div class="col font-weight-bold">
                                            Driver
                                        </div>
                                        <div class="col">
                                                <div v-if="! this.editForm">
                                                    <p v-if="record.driver == 0"> U Ba </p>
                                                    <p v-if="record.driver == 1"> U Mya </p>
                                                    <p v-if="record.driver == 2"> U Hla </p>
                                                </div>
                                                
                                                <div v-if="this.editForm">
                                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect0" v-model="record.driver">
                                            
                                                        <option value="0">U Ba</option>
                                                        <option value="1">U Mya</option>
                                                        <option value="2">U Hla</option>
                                                    </select>
                                                </div>

                                            </div>
                            </div>

                                            <div class="row my-2 py-2 border-bottom">
                                                <div class="col font-weight-bold">
                                                    Attach
                                                </div>
                                            
                                                <div class="col">
                                                    <p v-for="data  in record.attaches" :key="data" class= "text-small">
                                                        <a :href="`/download/maintain_record/attaches/`+data"> {{ data }} </a>
                                                    </p>
                                                </div>
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
    data() {
        return {

            editForm: false,

            moment: moment,

            record:{},

            lastMonth: moment().add(1, 'month').format("YYYY-MM-DD"),
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
            axios.patch(`/api/maintain_check/${this.$route.params.id}` , this.record)
            .then(response => {
                this.close();
                console.log(response);
            })

             .catch ( err => console.log(err));

        },
       
    },

     created() {
        axios.get(`/api/maintain_check/${this.$route.params.id}`)
        .then(response => {
            this.record = response.data.routine;
           
        })
    }
}
</script>