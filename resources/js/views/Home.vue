<template>
    <div>
        <div class="row mt-32">
            <div class="col-12">
                
                <h2>Carica file</h2>
                <div class="alert alert-success" v-show="success">
                    <h5 class="h5">Messaggio inviato correttamente</h5>
                </div>
                <div class="form mt-24">
                    <div>
                        <input v-on:change="previewFiles" type="file" placeholder="Seleziona il file excel da caricare" name="file_upload" :class="{ 'is-invalid' : errors.file }" ref="file_upload">
                        <br>
                        <small :class="{ 'text-danger' : errors.file }" v-if="errors.file">Formato non accettato, carica un csv o xlsx</small>
                        <small :class="{ 'text-danger' : errors.required }" v-if="errors.required">Carica almeno un file</small>

                    </div>
                    <div class="mt-24">
                        <input type="checkbox" name="header_row" v-model="checked"> La prima riga del file sono titoli?
                        <br>
                        <small>Selezionando questa opzione la prima riga non verrà considerata</small>
                    </div>
                    <button  v-on:click="submitForm()" class="btn btn-success mt-40" :disabled="sending" >
                        {{ sending ? 'Invio in corso' : 'SALVA' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
  </template>
  
  <script>

  export default {
    name: 'Home',
    data(){
      return{
        file_upload:[],
        errors: {
            "file":"",
            "required":""
        },
        success: false,
        checked: true,
        sending: false,
        filesSelected: 0,
        pippo: ''
      }
    },
    methods: {
    submitForm(){
        let formData = new FormData();
        formData.append('file', this.file_upload);
        formData.append('checked', this.checked);
        //dati inviati pulsante bloccato
        this.sending = true;
        axios.post('http://localhost:8000/api/uploadcsv',
            formData,
            {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }
        ).then(function(result){
            console.log('result', result.data);
            //dati inviati pulsante sbloccato
            this.sending = false;
            this.success = true;
            this.errors.required = "";
        }).catch((err) => {
            console.log('cspire',err);
            this.errors.file = ""
            this.errors.required = "required"
            this.sending = false
        });
    },
    previewFiles(event) { 
        if(event.target.files.length > 0) {
            this.filesSelected = 1
            this.file_upload = event.target.files[0];
            let fileExt = event.target.files[0].name.split('.').pop();
            if( fileExt !== 'xlsx') {
                this.errors.file = "mime"
                this.errors.required = ""
            }
            this.errors.required = ""
        }else {
            this.errors.file = ""
        }
    }
  }
}
  </script>
  
  <style>
  
  </style>