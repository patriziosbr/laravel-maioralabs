<template>
    <div>
        <div class="row mt-32">
            <div class="col-12">
                <h2>Carica file</h2>
                <div class="alert alert-success" v-show="success">
                    <h5 class="h5">Messaggio inviato correttamente</h5>
                </div>
                <form class="form mt-24" method="POST" @submit.prevent="sendForm">
                    <input v-on="file_upload" type="file" placeholder="Seleziona il file excel da caricare" name="file_upload" :class="{ 'is-invalid' : errors.file_upload }">
                    <button type="submit" class="btn btn-success mt-40" :disabled="sending">
                        {{ sending ? 'Invio in corso' : 'SALVA' }}
                    </button>
                </form>
            </div>
            <br>
            <br>
            <br>
            {{test}}
        </div>
    </div>
  </template>
  
  <script>

  export default {
    name: 'Home',
    data(){
      return{
        file_upload:'',
        errors: {},
        success: false,
        sending: false,
        test: {}
      }
    },
    methods: {
        getTest() {
            axios.get('http://127.0.0.1:8000/api/job')
            .then(res => {
                console.log(res.data.product);
                this.test = res.data.product;
            }).catch(err => {
                console.log('Service error: ', err)
            });
        }
    },
    created() {
        this.getTest();
    }
  }
  </script>
  
  <style>
  
  </style>