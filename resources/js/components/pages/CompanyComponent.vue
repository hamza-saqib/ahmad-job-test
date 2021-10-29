<template>
    <div class="">
        <DashboardHeader />
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form id="myForm" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Company Name</label>
                                    <div class="col-md-6">
                                        <input v-model="record.name" type="text" class="form-control " name="name" required autofocus>
                                        <small>
                                            <span v-if="errors.name != null" class="text-danger">
                                                {{errors.name[0]}}
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input v-model="record.email" id="email" type="email" class="form-control" name="email" required>
                                    </div>
                                    <small>
                                        <span v-if="errors.email != null" class="text-danger">
                                            {{errors.email[0]}}
                                        </span>
                                    </small>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-md-4 col-form-label text-md-right">Website</label>
                                    <div class="col-md-6">
                                        <input v-model="record.website" id="website" type="text" class="form-control" name="website" required>
                                        <small>
                                            <span v-if="errors.website != null" class="text-danger">
                                                {{errors.website[0]}}
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-md-4 col-form-label text-md-right">Logo</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control input-rounded" name="logo">
                                        <small>
                                            <span v-if="errors.logo != null" class="text-danger">
                                                {{errors.logo[0]}}
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" id="submit" v-if="record.id == 0" class="btn btn-primary btn-rounded btn-floating"
                                            @click.prevent="save()">Save</button>
                                        <button type="submit" id="submit" v-if="record.id != 0" class="btn btn-primary btn-rounded btn-floating"
                                            @click.prevent="update()">Update</button>
                                        <button type="button" class="btn btn-info btn-rounded btn-floating" @click.prevent="clearForm()">Clear
                                            Form</button>
                                    </div>
                                </div>
                            </form>
                            <div style="margin-top: 20px" :class="'mt-20 alert-rounded alert-dismissible fade show alert alert-' + response.type"
                                v-if="response.isVisible">
                                {{response.message}}
                            </div>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped" style=" box-shadow: 0 8px 4px -9px black"> 
                                        <thead >
                                        <tr class="text-center text-white bg-dark">
                                                <td>S.No</td>
                                                <td>Logo</td>
                                                <td>Company Name</td>
                                                <td>Email</td>
                                                <td>Website</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody class="table-striped">
                                            <tr v-for="(item, index) in items.data" :key="index">
                                                <td>{{index + 1}}</td>
                                                <td width="60">
                                                    <a :href="'/images/'+item.logo" target="_blank">
                                                        <img width="50" :src="'/images/'+item.logo" :alt="'item.name'">
                                                    </a>
                                                </td>
                                                <td>{{item.name}}</td>
                                                <td>{{item.email}}</td>
                                                <td>{{item.website}}</td>
                                                <td><a class="btn btn-sm" @click="recordDelete(item.id)">Delete</a>
                                                <a class="btn btn-sm" @click="edit(item.id)">Edit</a> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination :limit="4" :data="items" @pagination-change-page="getData"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import DashboardHeader from './DashboardHeader.vue';
  export default {
    data(){
        return {
            record: {
                id: 0,
                name: '',
                email: '',
                website: '',
            },
            items: {},
            errors: [],
            response: {
                type: "success",
                message: "",
                isVisible: false
            },
            
        }
    },
    components: {
        DashboardHeader,
    },
    computed:{
    
    },
    methods: {
        save() {
            var $myForm = $('#myForm');
            var data = new FormData(myForm);
            axios.post('/api/companies', data)
            .then((res) => {
                console.log(res)
                if (res.data.success == true) {
                    this.response = {
                        isVisible: true,
                        message: res.data.message,
                        type: 'success'
                    }
                    this.clearForm()
                    this.errors = []
                    this.getData()
                        
                } else {
                    this.errors = res.data.errors
                }
            })
            .catch((err) => {

            })
        },
        getData(page = 1) {
            axios.get('api/companies/all?page='+page)
                .then((res) => {
                    this.items = res.data
                })
        },
        recordDelete(id) {
            axios.delete('api/companies/' + id)
            .then((res) => {
                this.response = {
                    isVisible: true,
                    message: res.data.message,
                    type: 'danger'
                }
                this.errors = []
                this.getData()
            })
        },
        clearForm(){
            this.record = {
                id: 0,
                name: '',
                email: '',
                website: '',
            }
        },
        edit(id) {
            axios.get('api/company/edit/' + id)
            .then((res) => {
                this.record = res.data
            })
            this.response = {
                type: "success",
                message: "",
                isVisible: false
            }
        },
        update() {
            axios.patch('/api/companies/{this.record.id}',  {
                data : this.record})
            .then((res) => {
                if (res.data.success == false) {
                    this.errors = res.data.errors
                    this.response = {
                        isVisible: false
                    }
                } else {
                    this.clearForm()
                    this.response = {
                        isVisible: true,
                        message: res.data.message,
                        type: 'success'
                    }
                    this.errors = []
                    this.getData()
                }
            })
        },
    },
    mounted() {
        this.getData()
    }
  } 
</script>