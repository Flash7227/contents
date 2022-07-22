<template>
    <div class="container-fluid"
        v-loading.fullscreen.lock="loading"
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        element-loading-text="Уншиж байна...">
        
        <el-card class="user-card">
            <div slot="header">
                <span >
              
                <el-button  style="float: right;" plain type="success" icon="el-icon-circle-plus" @click="openDetail">Хэрэглэгч нэмэх</el-button>
                </span>
            </div>

        <el-table
        border
        :data="list.data"
        class="mt-5"
        style="width: 100%"
        
        header-cell-class-name="table-header">
            <el-table-column
                prop="email"
                label="И-мэйл"
                align="center" header-align="center"
                >
            </el-table-column>
            <el-table-column
                prop="name"
                label="Нэр"
                align="center" header-align="center"
                >
            </el-table-column>
            <el-table-column
                prop="permissions"
                label="Зөвшөөрөл"
                align="center" header-align="center"
                >
                <template slot-scope="scope">
                    {{ permissionsValue(scope.row.permissions) }}
                </template>
            </el-table-column>
            <el-table-column
                prop="role"
                label="Зэрэглэл"
                width="200"
                align="center" header-align="center"
                >
                <template slot-scope="scope">
                    {{ roleValue(scope.row.role) }}
                </template>
            </el-table-column>
            <el-table-column
                prop="edit"
                label="Үйлдэл"
                width="250"
                align="center" header-align="center"
                >
                <template slot-scope="scope">
                    <el-button  icon="el-icon-edit" type="primary" plain @click="openDetail(scope.row)" size="small">Засах</el-button>
                    <el-button  icon="el-icon-delete" type="danger" plain @click="deleteForm(scope.row.id)" size="small">Устгах</el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination :data="list" @pagination-change-page="fetch" :limit="3" align="center" class="my-2"></pagination>


        <el-dialog title="Хэрэглэгчийн мэдээлэл" :visible.sync="invisDetail" width="70%">
            <el-form :model="form" ref="formData" :rules="rules"  label-position="top">
                <el-form-item label="Нэр" prop="name">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="И-мэйл" prop="email">
                    <el-input v-model="form.email" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item label="Зөвшөөрөл" prop="permissions">
                    <el-select v-model="form.permissions" multiple placeholder="сонгох">
                        <el-option v-for="permission in permissions" :key="permission" :label="permission" :value="permission"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Зэрэглэл" prop="role">
                    <el-select v-model="form.role" placeholder="сонгох">
                        <el-option v-for="role in roles" :key="role.value" :label="role.label" :value="role.value"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item 
                v-if="form.password != null"
                label="Нууц үг" prop="password">
                    <el-input type="password" v-model="form.password" autocomplete="off"></el-input>
                </el-form-item>
                
                <el-form-item>
                    <el-button class="float-right" type="primary" @click="submitForm('formData')">
                        <span v-if="form.id">Засах</span>
                        <span v-else>Нэмэх</span>
                    </el-button>
                    <el-button class="float-right mr-2" @click="cancelDetail()">Хаах</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        </el-card>
    </div>
</template>

<script>
export default {
    data(){
        return{
            loading:false,
            invisDetail: false,
            list:{},
            form:{
                id:'',
                name:'',
                email:'',
                role:'',
                permissions:[],
                password: ''
            },
            allTags:[],

            rules: {
                    name: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    email: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    permissions: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    role: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ]
            },

            roles:[
                    {
                        label: 'Админ',
                        value : 1
                    },
                    {
                        label: 'Энгийн хэрэглэгч',
                        value : 0
                    },
                    {
                        label: 'Дотоод ажилтан',
                        value : 2
                    }
            ],

            permissions:['public', 'share'],
    

        }
    },
    methods:{
       

        fetch(page = 1){
                this.loading = true;
                axios.post("/admin/user/fetch?page=" + page, {search: this.search})
                .then(response => {
                    this.loading = false;
                    this.list = response.data;
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error.response);
                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                });
            },
            

        openDetail(data){
            console.log(data);
                if(data){
                    this.form.id = data.id;
                    this.form.name = data.name;
                    this.form.email = data.email;
                    this.form.role = data.role;
                    this.form.permissions = data.permissions;
                    this.invisDetail = true;
                }else{
                    this.cancelDetail();
                    this.invisDetail = true;
                }
        },

        submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        //submitting part begins here
                        this.$confirm('Итгэлтэй байна уу?', 'Warning', {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Cancel',
                            type: 'warning'
                        }).then(() => {
                            this.loading = true;
                            axios.post("/admin/user", {form: this.form})
                            .then(response => {
                                this.loading = false;
                                console.log(response.data);
                                if(response.data == "success"){
                                    this.$notify({
                                        title: 'Success',
                                        message: 'Амжилттай хадгаллаа',
                                        type: 'success'
                                    });
                                    this.cancelDetail();
                                    this.fetch();
                                }else{
                                    this.loading = false;
                                    this.$notify.error({
                                        title: 'Error',
                                        message: response.data
                                    });
                                };
                            })
                            .catch(error => {
                                this.loading = false;
                                console.log(error.response);
                                this.$notify.error({
                                    title: 'Error',
                                    message: error.response.data.message
                                });
                            });
                        }).catch(() => {
                            this.$message({
                                type: 'info',
                                message: 'Цуцлагдлаа!'
                            });          
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
        },

        cancelDetail(){
                this.form.name = "";
                this.form.email = "";
                this.form.role = "";
                this.form.permissions = [];
                this.form.password = "";
                this.invisDetail = false;
        },

        deleteForm(id) {
                this.$confirm('Итгэлтэй байна уу?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.loading = true;
                    axios.post("/admin/user", {id:id, delete: true})
                    .then(response => {
                        this.loading = false;
                        console.log(response.data);
                        if(response.data == "success"){
                            this.$notify({
                                title: 'Success',
                                message: 'Амжилттай!',
                                type: 'success'
                            });
                            this.cancelDetail();
                            this.fetch();
                        }else{
                            this.loading = false;
                            this.$notify.error({
                                title: 'Error',
                                message: response.data
                            });
                        };
                    })
                    .catch(error => {
                        this.loading = false;
                        console.log(error.response);
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Цуцлагдлаа!'
                    });          
                });
        },

        permissionsValue(dat){
            console.log(dat);
                if(dat){
                    return dat.join(', ');
                }
                return dat;

            },

        
        

        roleValue(value){
             
                if(value === null){
                    return value = 'null';
                }else if(value === 1){
                    return value = 'Админ';
                }else if(value === 0){
                    return value = 'Энгийн хэрэглэгч';
                }else if(value === 2){
                    return value == 'Дотоод ажилтан';
                }else{
                    return value === 'Хоосон'
                }
            },

    },
    
    created(){
        this.fetch();
    },

    mounted(){},

    props: {
        csrf: {
            type: String,
        },
    }

}
</script>

<style>


  .user-card {
    width: 90%;
    margin: auto;
  }

  .table-header{
    background: #3897e4 !important;
    color: white;
    text-transform: uppercase;
    font-size: 0.9em;
    line-height: auto;
  }

</style>