<template>
    <div class="">
        <Header />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input v-model="record.name" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input v-model="record.email" id="email" type="email" class="form-control" name="email" required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input v-model="record.password" id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input v-model="record.confirm_password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Header from './Header.vue'
  export default {
    data(){
        return {
            record: {
                name: '',
                email: '',
                password: '',
                confirm_password: '',
            },
        }
    },
    components:{
        Header
    },
    methods: {
        register(){
            axios.post('api/register', this.record)
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