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
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Company</label>
                                    <div class="col-md-6">
                                        <select class="form-control input-rounded" v-model="record.company_id">
                                            <option value="" disabled hidden>-- Select --</option>
                                            <option v-for="company in companies" :key="company.id" :value="company.id">{{company.name}}</option>
                                        </select>
                                        <small>
                                            <span v-if="errors.company_id != null" class="text-danger">
                                                {{errors.company_id[0]}}
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">First Name</label>
                                    <div class="col-md-6">
                                        <input v-model="record.first_name" type="text" class="form-control " name="first_name" required autofocus>
                                        <small>
                                            <span v-if="errors.first_name != null" class="text-danger">
                                                {{errors.first_name[0]}}
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                    <div class="col-md-6">
                                        <input v-model="record.last_name" type="text" class="form-control " name="last_name" required autofocus>
                                        <small>
                                            <span v-if="errors.last_name != null" class="text-danger">
                                                {{errors.last_name[0]}}
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
                                    <label  class="col-md-4 col-form-label text-md-right">Phone</label>
                                    <div class="col-md-6">
                                        <input v-model="record.phone" id="phone" type="text" class="form-control" name="phone" required>
                                        <small>
                                            <span v-if="errors.phone != null" class="text-danger">
                                                {{errors.phone[0]}}
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
                                                <td>First Name</td>
                                                <td>Last Name</td>
                                                <td>Email</td>
                                                <td>Phone</td>
                                                <td>Company</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody class="table-striped">
                                            <tr v-for="(item, index) in items.data" :key="index">
                                                <td>{{index + 1}}</td>
                                                <td>{{item.first_name}}</td>
                                                <td>{{item.last_name}}</td>
                                                <td>{{item.email}}</td>
                                                <td>{{item.phone}}</td>
                                                <td>{{item.company.name}}</td>
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
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                company_id: '',
            },
            items: {},
            errors: [],
            companies: [],
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
    created(){
        this.getData()
        this.getCompanies()

    },
    methods: {
        save() {
            axios.post('/api/employees', this.record)
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
            axios.get('api/employees/all?page='+page)
                .then((res) => {
                    this.items = res.data
                })
        },
        recordDelete(id) {
            axios.delete('api/employees/' + id)
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
            axios.get('api/employees/edit/' + id)
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
            axios.patch('/api/employees/{this.record.id}',  {
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
        getCompanies(){
            axios.get('api/get-companies')
            .then((res) => {
                this.companies = res.data
            })
        }
    },
    mounted() {
    }
  } 
</script>