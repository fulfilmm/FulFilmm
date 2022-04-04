<template>
    <div>
            <h2 class="text-center my-2"> Create Invoice </h2>
        <div class=" p-3 mx-2">

            <div class=" p-3 mt-2 mb-5">

                <!---------------------------------  for invoice type -------------------------------------------->
                    <div class="d-flex justify-content-around mb-3">
                        <div>
                                <div class="form-group">
                                        <label for="exampleFormControlSelect1">Choose Inoice Type</label>
                                        <select  class="custom-select mr-sm-2" id="inlineFormCustomSelect1" required>
                                        <option>General Invoice</option>
                                        <option>Cash On Delivery</option>
                                        </select>
                                    </div>
                        </div>
                        <div>
                             <div class="form-group col-md-6 col-sm-12 mx-auto">
                                      <label for="invoice_date" > Invoice Date </label>
                                      <date-picker  valueType="format" placeholder="choose date" v-model="orderInfo.order_date"></date-picker>
                                </div>
                        </div>
                        <div>
                                  <div class="form-group col-md-6 col-sm-12 mx-auto">
                                      <label for="due_date"> Due Date </label>
                                      <date-picker  valueType="format" placeholder="choose date" v-model="orderInfo.due_date"></date-picker>
                                </div>
                        </div>
                    </div>

                    <!------------------------- end ------------------------------>


                    <!------------------------- customer info ------------------------>
                    <div class="row">
                            <div class=" bg-light shadow-lg col-md-8 p-2 mx-auto cus-card">
                                <div class=" border-bottom">
                                    <h4 class=" my-2 text-secondary"> Please Select Customer, </h4>
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" required>
                                        <option @click="selectCus()"> Select Customer</option>                    
                                        <option v-for="cus in customers" :key="cus.id" :value=cus.id @click="cusData(cus)">{{cus.name}}</option>
                                    </select>
                                </div>
                                <div v-if="this.viewForm">
                                    <div class="row mt-3 px-3">
                                        <div class="col">
                                            <p> Name </p>
                                            <p> Customer Type</p>
                                            <p> Phone Number </p>
                                            <p> Email</p>
                                            <p> Address </p>
                                        </div>
                                        <div class="col font-weigth-bold">
                                            <p>{{ customer.name}}</p>
                                            <p>{{ customer.customer_type}}</p>
                                            <p> {{ customer.phone}} </p>
                                            <p>{{ customer.email}}</p>
                                            <p>{{ customer.address}}</p>
                                        </div>
                                    </div>
                                    <div class=" bg-white px-2 py-3">
                                        <h5>Add On</h5>
                                         <div class="form-group">
                                            <label for="formGroupExampleInput">Add Title</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput2">Shipping Address</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
                                        </div>
                                           <div class="form-group">
                                            <label for="" class="form-label"> Input Description</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-md-3 px-3 py-2 mx-2 my-2 payment-card">
                                     <div class="form-group">
                                        <label for="exampleFormControlSelect1">Choose Payment type</label>
                                        <select  class="custom-select mr-sm-2" id="inlineFormCustomSelect1" required>
                                        <option>Cash</option>
                                        <option>KBZPay</option>
                                        <option>Wave Money</option>
                                        </select>
                                    </div>

                                     <div class="form-group">
                                        <label for="exampleFormControlSelect1">Choose Warehouse</label>
                                        <select  class="custom-select mr-sm-2" id="inlineFormCustomSelect1" required>
                                        <option> Main Warehouse</option>
                                       
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Delivery Free
                                            </label>
                                            </div>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                            <label class="form-check-label" for="exampleRadios2">
                                                Not Delivery Free
                                            </label>
                                        </div>
                                    </div>
                                    
                            </div>
                </div>
            </div>

            <div>

            </div>
             <!-- <div class="nav d-flex justify-content-between">
                <input v-model="keyword" class="form-control" type="text" placeholder="Search" aria-label="Search">
                <div v-bind:key="result.id" v-for="result in results">
                <p>Results are: {{ result.title }}</p>
                </div>
            </div> -->

            <div class=" sale_card px-3 py-4 my-3">

                <div class="border-bottom d-flex flex-row">
                    <div class="mx-2">
                        <font-awesome-icon icon="fa-barcode" class="btn btn-info rounded-pill text-white text-lg"></font-awesome-icon>
                    </div>
                      <div class="mx-2">
                        <p class="btn btn-success rounded-pill text-white"> FOC </p>
                    </div>
                     <div class=" mx-2 text-secondary">
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">                    
                            <option v-for="product in products" :key="product.id" @click="cart(product)">{{product.variant.product_name}}</option>
                        </select>
                    </div>

                </div>
             
            
                
                <div class=" p-3">
                    <table class="table table-striped text-center">
                        <thead class=" font-weight-bold">
                            <tr>
                        
                            <th class="w-25">Product</th>
                            <th class="w-25">Quantity</th>
                            <th class="w-25">Price</th>
                            <th class="w-25"> Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in cartItems" :key="item.id">

                                    <td>{{item.variant.product_name}}</td>
                                    <td>
                                        <button @click="cartData(item)" class="btn btn-success rounded-pill"> + </button>
                                        {{item.quantity}}
                                        <button @click="removed(item)" class="btn btn-danger rounded-pill"> - </button>

                                    </td>
                                    <td>{{item.variant.purchase_price}}</td>
                                    <td> {{item.quantity * item.variant.purchase_price}}</td>
                        
                            </tr>
                            
                        </tbody>
                        <tfoot>
                            <tr class="">
                                <td colspan="3" class="font-weight-bold"> Total </td>
                                <td class="font-weight-bold">{{getTotal}} </td>
                            </tr>

                            <tr class="">
                                <td colspan="3" class="font-weight-bold"> Discout</td>
                                <td class="d-flex flex-row-reverse"> 
                                         <small class="text-muted mx-3 text-lg"> {{addDis}} </small>    
                                        <input type="number" v-model="discount" class="form-control form-control-sm  rounded-pill" placeholder=" discount %">
                                       
                                </td>
                            </tr>
                            <tr class="">
                                
                                <td colspan="3" class="font-weight-bold">
                                    Add Tax
                                </td>
                                <td class="d-flex flex-row-reverse">
                                      <small class="text-muted mx-3 text-lg"> {{addTax}} </small>
                                    <input type="number" v-model="tax" class="form-control form-control-sm rounded-pill " placeholder=" Tax %">
                                  
                                </td>
                            </tr>
                            <tr class="">
                                <td colspan="3" class="font-weight-bold">
                                    Deli Fees
                                </td>
                                <td class="d-flex flex-row-reverse">
                                
                                        <input type="number" v-model="deli" class="form-control form-control-sm rounded-pill border-none"> 
                                    
                                </td>
                            </tr>
                        
                            <tr class="">
                                <td colspan="3" class="font-weight-bold"> Grand Total</td>
                                <td class="font-weight-bold">{{ addTotal}} </td>
                            </tr>
                        </tfoot>
                        </table>
                </div>

                
            </div>

            <div class="d-flex flex-row-reverse">
                    <button class="btn btn-info rounded-pill shadow-lg px-3 mb-5 mx-2"> Save and Print</button>
                    <button class="btn btn-primary rounded-pill shadow-lg px-3 mb-5 mx-2"> Save </button>
            </div>

        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';


export default ({
    components: { DatePicker},
    data() {
        return {
            viewForm: false,

            customers:[],

            // results:[],
            // keyword:'',

            products:[],

            focs:[],

            orderInfo:{
                due_date:'',
                order_date:'',
            },

            cartProduct: {
                name:'',
                price:'',
                stock_balance:'',

            },
            tax:'',
            deli:'',
            discount:'',


            customer:{},

            cartProduct:{},
        }
    },

    // watch: {
    //     keyword: function(newVal){
    //         if(newVal.length > 2){
    //             this.getResult();
    //         }
    //     }
    // },
    
    methods: {

        // getResult(){
        //     axios.get('/api/invoice/?search="+this.keyword')
        //             .then(res => (this.results = res.data.customers))
        //             .catch( err => console.log(err));
        // },

        view(){
            axios.get('/api/invoice')
                .then((response) => {
                    this.customers = response.data.customers;
                    this.products = response.data.products;
                    this.focs = response.data.focs;
                })
                .catch ( err => console.log(err))
        },

        selectCus(){
            this.customer = {};
            this.viewForm = false;
        },

        cusData(cus){ 
            this.customer = Object.assign({},cus); 
            this.viewForm = true;
        },

        cart(product){
            this.$store.dispatch("addToCart", product)
        },

        cartData(item){
            this.$store.dispatch("addToCart", item)
        },

        removed(item){
            this.$store.dispatch("removeItem", item)
        },

      

    },

    computed: {

        
        cartItems(){
            return this.$store.state.cartItems;
        },

      
        ...mapGetters(["getTotal"]),

        addTotal(){
          let a = Number(this.getTotal);
          let b = Number(this.addTax);
          let d = Number(this.deli);
          let dis = Number(this.addDis)
          let c = (a - dis) + ( b + d );
          return c 
        },

        addTax(){
            let t = Number(this.tax);
            let amt = Number(this.getTotal);
            let tax = (amt / 100)*t;

            return tax
        },

        addDis(){
            let d = Number(this.discount);
            let amt = Number(this.getTotal);
            let dis = (amt/100)*d;

            return dis;
        }

    },

    created() {
        this.view();
        //this.getResult();
       // this.totalAmt();
    },
})
</script>

<style scoped>

    .cus-card{
        background-color: cornsilk;
        border-radius: 5%;
    }
    .payment-card {
        background-color: honeydew;
        border-radius: 5%;
    }

    .sale_card{
        background-color: rgb(247, 247, 247);
        border-radius: 10px;
    }
</style>
