import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
      cartItems:[]
     
  },
  mutations: {
    addToCart (state, payload){

        let item = payload;
        item = { ...item, quantity:1}

        if(state.cartItems.length > 0){
            let bool = state.cartItems.some(i =>i.id == item.id)
            if(bool){
            
            let itemIndex = state.cartItems.findIndex ( el => el.id === item.id)
            state.cartItems[itemIndex]["quantity"] += 1;
        }

        else{
            state.cartItems.push(item)
        }
    }

        else{
            state.cartItems.push(item)
        }

    },

    removeItem( state, payload){
        if( state.cartItems.length > 0) {
          let bool = state.cartItems.some(i => i.id === payload.id)

          if(bool) {
            let index = state.cartItems.findIndex(el => el.id === payload.id)

            if(state.cartItems[index]["quantity"] !== 0){
              state.cartItems[index]["quantity"] -= 1
            }

            if( state.cartItems[index]["quantity"] === 0){
              state.cartItems.splice(index, 1)
            }

          
          }
        }
    },
    

  clearCart( state, cartItems){
      state.cartItems = cartItems;
  }

},

getters: {
    getTotal : state => {
        return state.cartItems.reduce((total, lineItem) => total + (lineItem.quantity * lineItem.variant.purchase_price), 0);
    }
},

actions: {
    addToCart: (context, payload) => {
        context.commit("addToCart" , payload)
    },

    removeItem: (context, payload) => {
       context.commit("removeItem" , payload)
    },

    clearCart ({commit}){
        commit('clearCart', []);
    }
}


  
})