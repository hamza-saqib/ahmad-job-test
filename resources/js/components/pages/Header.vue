<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                Laravel
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'Login' }">Login</router-link>
                    </li>
                    
                    <li class="nav-item">
                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'Register' }">Register</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
  export default {
    name: 'login-header',
    data(){
      return {
          
      }
    },
    computed:{
    },
    methods: {
        
    },
    mounted() {
        console.log('Home Template Loaded');
    }
  } 
</script>