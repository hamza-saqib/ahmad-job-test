<template>
    <div>
        <DashboardHeader />
        <div class="container text-center p-3">
            <h1>Welcome To Dashboard</h1>
        </div>
    </div>
</template>
<script>
    import DashboardHeader from './DashboardHeader.vue';
  export default {
    data(){
        return {
            record: {
                email: '',
                password: '',
            },
        }
    },
    components: {
        DashboardHeader,
    },
    computed:{
    
    },
    methods: {
        login(){
            axios.post('api/login', this.record)
            .then((response) => {
                console.log(response)
                if(response.data.status == 'success'){
                    this.$router.push('/dashboard')
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