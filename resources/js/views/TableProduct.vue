<template>
    <div>
        <div v-if="products.length == 0">
            <h2 class="mt-16">Non ci sono prodotti qui</h2>
            <p class="mt-16">Trona a <a href="/">home</a> e carica un file</p>
        </div>
        <div v-else>
            <h2 class="mt-16">Risultati</h2>
            <div id="external_filter" class="dataTables_filter" style="margin: 20px 0;">
                <label>External Search:
                <input id="external_search" type="search" class="" placeholder="" aria-controls="prod">
                </label>
            </div>

            <table id="prod" class="display dataTable cell-border" style="width:100%">
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
                        <td v-if="product.percentage_discount">{{product.percentage_discount}}%</td>
                        <td v-else>0%</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
        // this.getProduct()
        setTimeout(() => {
            var table = $('#prod').DataTable({
            "initComplete": function(settings, json) {
                $('#prod_filter').remove();
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