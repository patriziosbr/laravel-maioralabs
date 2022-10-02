<template>
    <div>
        <h2 class="mt-16">Risultati</h2>

        <!-- {{products}} -->
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
                <th>Prezzo</th>
                <th>Sconto</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(product) in products" :key="product.id">
                <td>{{product.cod_article}}</td>
                <td>{{product.name}}</td>
                <td>{{product.category_name}}</td>
                <td>{{product.price}} €</td>
                <td>{{product.currency}} %</td>
            </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
export default {
    name: 'Discount',
    data(){
      return{
        products: [],
        errors: false,
        success: false,
        sending: false,
      }
    },
    methods: {
        getProduct() {
            axios.get('http://localhost:8000/api/productcateogries')
            .then(res => {
                console.log(res.data);
                this.products = res.data.product;
            }).catch(err => {
                console.log('Porduct error: ', err)
            });
        }
    },
    mounted() {
        this.getProduct()
        setTimeout(() => {
            var table = $('#animals').DataTable({
            "initComplete": function(settings, json) {
                $('#animals_filter').remove();
                }
            });

            $('#external_filter input').off().keyup(function () {
                table.search(this.value).draw();
            });
        }, 1000);
    }
}
    
</script>

<style>

</style>