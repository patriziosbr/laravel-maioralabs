<template>
  <div class="header_big container-fluid pb-24">
    <div class="row">
        <div class="col-12">
            <router-link to="/" class="d-flex flex-column align-items-center">
                <div class="logo-top mt-24">
                    <img src="https://www.spid.gov.it/wp-content/themes/dist/assets/images/logo.svg" alt="">
                </div>
                <h1 class="h1-white mt-32">MaioraLabs Project</h1>
            </router-link>
        </div>

    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss">
    @import '../../sass/utils/variables';

    .header_big {
        // height: 200px;
        background-color: $primary;
    }

    .logo-top {
        height: 50px;
        width: 50px;
    }

    h1 {
        color: $white;
        text-align: center;
    }

</style>>
