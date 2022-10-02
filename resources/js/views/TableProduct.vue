<template>
    <div>
        <h2 class="mt-16">Risultati</h2>

        <!-- {{product}} -->
    <div id="external_filter" class="dataTables_filter" style="margin: 20px 0;">
        <label>External Search:
        <input id="external_search" type="search" class="" placeholder="" aria-controls="animals">
        </label>
    </div>

    <table id="animals" class="display dataTable cell-border" style="width:100%">
        <thead>
            <tr>
                <th>Codice articolo</th>
                <th>Nome articolo</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>antelopes</td>
                <td>herd</td>
                <td>English</td>
            </tr>
            <tr>
                <td>elephants</td>
                <td>herd</td>
                <td>English</td>
            </tr>
            <tr><td>éléphants</td><td>troupeau</td><td>French</td></tr>
            <tr><td>Hounds</td><td>pack</td><td>English</td></tr>
            <tr><td>kittens</td><td>kindle</td><td>English</td></tr>
            <tr><td>lions</td><td>pride</td><td>English</td></tr>
            <tr><td>pingouins</td><td>colonie</td><td>French</td></tr>
            <tr><td>ravens</td><td>unkindness</td><td>English</td></tr>
            <tr><td>whales</td><td>pod</td><td>English</td></tr>
            <tr><td>zebras</td><td>herd</td><td>English</td></tr>
        </tbody>
    </table>
    </div>
</template>

<script>
export default {
    name: 'Discount',
    data(){
      return{
        product: [],
        errors: false,
        success: false,
        sending: false,
      }
    },
    methods: {
        // getProduct() {
        //     axios.get('http://localhost:8000/api/productcateogries')
        //     .then(res => {
        //         console.log(res.data);
        //         this.product = res.data.product;
        //     }).catch(err => {
        //         console.log('Porduct error: ', err)
        //     });
        // },
    },
    mounted() {
    
    var table = $('#animals').DataTable({
        "initComplete": function(settings, json) {
          $('#animals_filter').remove();
        }
      });

      $('#external_filter input').off().keyup(function () {
          table.search(this.value).draw();
      });
    }
}
    
</script>

<style>

</style>