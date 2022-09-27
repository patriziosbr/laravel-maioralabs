<template>
    <div>
      <TopHeaderVue/>
      <HeaderBig/>
      <div class="container">
        <router-view />
      </div>
    </div>
    </template>
    
    <script>
    
    import TopHeaderVue from './components/TopHeader.vue';
    import HeaderBig from './components/HeaderBig.vue'
    
    export default {
      components: { 
        TopHeaderVue,
        HeaderBig
      },
    
    }
    </script>
    
    

    <style lang="scss">
      @import '../sass/base/margin';
      @import '../sass/base/padding';

    </style>