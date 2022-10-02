<template>
    <div>
        <div v-if="items.length == 0">
            <h2 class="mt-16">Non ci sono categorie qui</h2>
            <p class="mt-16">Trona a <a href="/">home</a> e carica un file</p>
        </div>
        <div v-else>
            <h2 class="mt-16">Applica lo sconto per categoria</h2>
            <form class="form-group bnb-form" method="POST" @submit.prevent="sendForm" >
            <div class="row mt-48" v-for="(item, index) in items" :key="index">
                <div class="col-6">
                    <div class="select-wrapper">
                    <label for="defaultSelect">Categorie</label>
                    <!-- <select :id="`mySelect${index}`" @change="setSelectedValue(index)"> -->
                    <select :id="`mySelect${index}`" v-model="item.id">
                        <option selected="" value="">Scegli una categoria</option>
                        <option v-for="(option) in options" :value="option.id" :key="option.id"  v-show="isShown(option)" name="discount_opt">{{option.name}}</option>
                    </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label :for="`input-group-2${index}`" class="input-group-2">Applica uno sconto</label>
                        <input type="text" class="form-control input-field" :id="`input-group-2${index}`" placeholder="Sconto %" @keypress="isNumber($event, index)" max="100" ref="myInput" v-model="item.discount">
                    </div>
                </div>
            </div>
            <small class="d-block text-danger mb-24" v-if="errors">Sconto superiore al 100%</small>
            <button class="btn btn-success" type="submit" :disabled="sending">
            {{ sending ? 'Invio in corso' : 'SALVA' }}
            </button>
            </form>
        </div>
    </div>
  </template>
  
  <script>

  export default {
    name: 'Discount',
    data(){
      return{
        items: [],
        options: [],
        errors: false,
        success: false,
        sending: false,
      }
    },
    methods: {
        sendForm: function(){
            //dati inviati pulsante bloccato
            this.sending = true;
            axios.post('http://127.0.0.1:8000/api/applaydiscount', {
            category_discount: this.options
            }).then((result) => { 
            //dati inviati pulsante sbloccato
            console.log(result.data.errors);
            this.sending = false;
            if(result.data.errors){
                //errore in validazione
                this.errors = result.data.errors;
                console.log('qui',this.errors);
            } else {
                this.errors = false
            }
            }).catch((err) => {
            console.log('catch', err);
            });
        },
        isNumber(evt, index) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            this.items[index]['discount'] = ''
            // console.log(this.items[index]); ?? non ho capito ma funziona
            return true;
        }

        },
        getProduct() {
            axios.get('http://localhost:8000/api/discount-category')
            .then(res => {
                // console.log(res.data);
                this.options = res.data.category;
                this.items = res.data.category;
            }).catch(err => {
                console.log('Porduct error: ', err)
            });
        },
        isShown: function(option) {
            return !(this.items.map(item => item.id).includes(option.id));
        },
        // setSelectedValue(index) {
        //     // var selectobject = document.getElementById(`mySelect${index}`);
        //     var selectobject = document.getElementsByTagName('select');
            
        //     for (const key in selectobject) {
        //         console.log('key', key);
        //         console.log('selectobject', selectobject);
        //     }
           
        // },
        // isDisabled: function(option) {
        //     return this.items.map(item => item.value).includes(option.value);
        // },
        // remove: function () {
        //     if(this.$refs.dropdownObj.this.options.length > 1) {
        //         this.$refs.dropdownObj.options[0].remove();
        //         this.$refs.dropdownObj.dataSource.splice(0, 1);
        //     } else {
        //       this.options = [];
        //     }
        // }

    },
    created() {
        this.getProduct()
    },
    // computed: {
    //     select3() {
    //         return this.items.map(item => item.value).includes(option.value);
    //     },
    // }
  }
  </script>
  
  <style>
      @import '../../sass/utils/_variables.scss';
      label.input-group-2 {
            position: absolute;
            color: #435a70;
            font-size: .7777777778rem;
            display: block;
            font-weight: 600;
            padding: 0 0.5rem;
            line-height: calc(2.5rem - 1px);
            top: 0;
            transform: translateY(-75%);
        }
  </style>