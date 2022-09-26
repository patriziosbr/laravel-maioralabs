<template>
    <div>
      <header-guest></header-guest>
      <router-view />
    </div>
    </template>
    
    <script>
    
    import HeaderGuest from './components/HeaderGuest.vue'
    
    export default {
      components: { 
        HeaderGuest 
      },
    
    }
    </script>
    
    <style>
    
    </style>