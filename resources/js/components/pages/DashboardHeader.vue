<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                Dashboard
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
                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'Company' }">Add Company</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" data-toggle="collapse" :to="{ name: 'Employee' }">Add Employee</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" @click="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
  export default {
      
    data(){
      return {
          
      }
    },
    computed:{
    },
    methods: {
        logout()
        {
            axios.post('api/logout', this.record)
            .then((response) => {
                if(response.data.status == 'success'){
                    this.$router.push('/login')
                } else {
                    alert('Please try Again')
                }  
            });
        }
    },
    mounted() {
    }
  } 
</script>