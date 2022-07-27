<template>
    <div class="container-fluid"
        v-loading.fullscreen.lock="loading"
        element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)"
        element-loading-text="Уншиж байна...">
        
        <el-card class="user-card">
            <div slot="header" class="text-right">
              
                <el-button plain type="success" icon="el-icon-circle-plus" @click="openDetail">Хэрэглэгч нэмэх</el-button>
            </div>

        <el-table
        border
        :data="list.data"
        class="mt-5"
        style="width: 100%"
        
        header-cell-class-name="table-header">
            <el-table-column
                type="email"
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
                label=" Үйлдлийн эрх"
                align="center" header-align="center"
                >
                <template slot-scope="scope">
                    {{ permissionsValue(scope.row.permissions) }}
                </template>
            </el-table-column>

            <el-table-column
                prop="role"
                label="Эрхийн түвшин"
                width="200"
                align="center" header-align="center">
                <template slot-scope="scope">
                    {{ roleValue(scope.row.role) }}
                </template>
            </el-table-column>

            <el-table-column
                prop="storage_limit"
                label="боломжит файл хуулах хэмжээ"
                width="200"
                align="center" header-align="center">
                <template slot-scope="scope">
                    {{ storageLimitValue(scope.row.storage_limit)}}
                    <i class="el-icon-caret-right"></i>
                    {{ storageLimitValue(scope.row.uploaded)}}

                </template>
            </el-table-column>

            <el-table-column
                prop="edit"
                label="Үйлдэл"
                width="250"
                align="center" header-align="center">
                <template slot-scope="scope">
                    <el-button  icon="el-icon-edit" type="primary" plain @click="openDetail(scope.row)" size="small">Засах</el-button>
                    <el-button  icon="el-icon-delete" type="danger" plain @click="deleteForm(scope.row.id)" size="small">Устгах</el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination :data="list" @pagination-change-page="fetch" :limit="3" align="center" class="my-2"></pagination>

        <el-dialog title="Хэрэглэгчийн мэдээлэл" :visible.sync="invisDetail" :before-close="handleClose" :destroy-on-close="true">
            <el-form :model="form" ref="formData" :rules="rules"  label-position="left" autocomplete="off">
                <el-row :gutter="20" type="flex">
                    <el-col :span="12" :offset="6">
                        <el-form-item label="Нэр" prop="name">
                            <el-input v-model="form.name" autocomplete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :span="12" :offset="6">
                        <el-form-item label="И-мэйл" prop="email">
                            <el-input v-model="form.email" autocomplete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12" :offset="6">
                        <el-form-item label=" Үйлдлийн эрх" prop="permissions">
                            <el-select v-model="form.permissions" multiple placeholder="сонгох">
                                <el-option v-for="permission in permissions" :key="permission" :label="permission" :value="permission"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                     <el-col :span="12" :offset="6">
                        <el-form-item label="Эрхийн түвшин" prop="role">
                            <el-select v-model="form.role" placeholder="сонгох">
                                <el-option v-for="role in roles" :key="role.value" :label="role.label" :value="role.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                     <el-col :span="12" :offset="6">
                        <!------------- shineer user vvsgeh dialogiih   -------------->
                        <el-form-item
                        v-if="!!form.id"
                         label="Файл хуулах хэмжээ">
                            <div style="margin-bottom: 1em;">
                                <el-select v-model="storage_limit_ext" placeholder="сонгох">
                                    <el-option v-for="size in sizes" :key="size.value" :label="size.label" :value="size.value"></el-option>
                                </el-select>
                            </div>
                            <div>
                            <el-input  type="text" placeholder="оруулах файлын хэмжээг бичнэ үү..." v-model="temporary_storage_limit" clearable></el-input>
                            <!-- <el-input  type="text" placeholder="formiiin inputttt" v-model="form.storage_limit"  clearable></el-input> -->
                            </div>
                        </el-form-item>

                        <el-form-item
                        v-else
                         label="Файл хуулах хэмжээ" prop="storage_limit">
                            <div style="margin-bottom: 1em;">
                                <el-select v-model="storage_limit_ext" placeholder="сонгох">
                                    <el-option v-for="size in sizes" :key="size.value" :label="size.label" :value="size.value"></el-option>
                                </el-select>
                            </div>
                            <div>
                            
                            <!-- < v-if="!!form.id" type="text" placeholder="файл оруулах хэмжээг бичих" v-model="temporary_storage_limit" clearable></     el-input> -->
                            <el-input type="text" placeholder="оруулах файлын хэмжээг бичнэ үү..." v-model="form.storage_limit" clearable autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');"></el-input>
                            </div>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                     <el-col :span="12"  :offset="6">
                        <el-form-item 
                        v-if="!form.id"
                        label="Нууц үг" prop="password">
                            <el-input type="password" v-model="form.password" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" placeholder="Нууц үг шинээр оруулах" min="4" show-password pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required></el-input>
                        </el-form-item>
                        <el-form-item
                        v-else 
                        label="Нууц үг">
                            <el-input type="password" v-model="form.password" autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly');" placeholder="Нууц үг шинээр оруулах" min="4" show-password pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required></el-input>
                        </el-form-item>
                     </el-col>
                </el-row>
                <el-row :gutter="20">
                     <el-col :span="10"  :offset="5">
                        <el-form-item>
                            <el-button class="float-right mb-2" type="primary" @click="submitForm('formData')">
                                <span v-if="form.id"><i class="el-icon-circle-check"></i> Засах</span>
                                <span v-else><i class="el-icon-circle-check"></i> Нэмэх</span>
                            </el-button>
                            <el-button class="float-right mr-2" @click="cancelDetail()"><i class="el-icon-remove-outline"></i> Хаах</el-button>
                        </el-form-item>
                     </el-col>
                </el-row>
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
                storage_limit:'',
                password: ''
            },
            allTags:[],

            rules: {
                    name: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    email: [
                        { required: true, type: 'email', message: 'И-мэйл хаяг оруулна уу', trigger: 'blur' }
                    ],
                    permissions: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    role: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    storage_limit: [
                        { required: true, message: 'Заавал бөглөх', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: 'Заавал бөглөх, 4-өөс дээш оронтой байх', Min: 4, trigger: 'blur' }
                    ],
                    
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

            sizes: [
                {
                    value: "gb",
                    label: "GB",
                },
                {
                    value: "mb",
                    label: "MB",
                }
            ],
            storage_limit_ext:'',
            temporary_storage_limit: '',

            permissions:['public', 'upload', 'user_modify'],
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
            this.storage_limit_ext = null;
                if(data){
                    this.form.id = data.id;
                    this.form.name = data.name;
                    this.form.email = data.email;
                    this.form.role = data.role;
                    this.form.permissions = data.permissions;
                    // this.storage_limit = '';
                    this.temporary_storage_limit = this.temporaryStorageLimitValue(data.storage_limit);
                    this.invisDetail = true;
                }else{
                    this.cancelDetail();
                }
        },

        submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        //submitting part begins here
                      
                        this.$confirm('Итгэлтэй байна уу?', 'Warning', {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'цуцлах',
                            type: 'warning'
                        }
                        )
                        .then(() => {
                            
                            var extValue = this.storage_limit_ext;
                            var formNumberValue = this.form.storage_limit;
                            var temporaryNumberValue = this.temporary_storage_limit;

                            if(this.form.id){

                                if(extValue === 'gb'){
                                    var convertToByte = (temporaryNumberValue * 1073741824); 
                                }
                                else if(extValue === 'mb'){
                                    var convertToByte = (temporaryNumberValue * 1048576); 
                                }else if(!extValue){
                                    var convertToByte = 0;
                                }

                            } else {
                                if(extValue === 'gb'){
                                    var convertToByte = (formNumberValue * 1073741824); 
                                }
                                else if(extValue === 'mb'){
                                    var convertToByte = (formNumberValue * 1048576); 
                                }else if(!extValue){
                                    var convertToByte = 0;
                                }
                            }
                            this.form.storage_limit =  convertToByte;
                            
                            console.log(convertToByte);
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

                                var extValue = this.storage_limit_ext;
                            var formNumberValue = this.form.storage_limit;
                            var temporaryNumberValue = this.temporary_storage_limit;

                            if(this.form.id){

                                if(extValue === 'gb'){
                                    var convertToByte = (temporaryNumberValue / 1073741824); 
                                }
                                else if(extValue === 'mb'){
                                    var convertToByte = (temporaryNumberValue / 1048576); 
                                }else if(!extValue){
                                    var convertToByte = 0;
                                }

                            } else {
                                if(extValue === 'gb'){
                                    var convertToByte = (formNumberValue / 1073741824); 
                                }
                                else if(extValue === 'mb'){
                                    var convertToByte = (formNumberValue / 1048576); 
                                }else if(!extValue){
                                    var convertToByte = 0;
                                }
                            }
                            this.form.storage_limit =  convertToByte;
                                
                                console.log(error.response.data);

                                var errormsg = error.response.data.message;
                                var text = '23000';
                                if (errormsg.indexOf(text) >= 0) { 
                                 this.$notify.error({
                                    title: 'Error!',
                                    message: 'Бүртгэлтэй и-мэйл байна'
                                });
                                }
                                else{
                                    this.$notify.error({
                                        title: 'Error!',
                                    
                                        message: 'Нууц үг оруулна уу'
                                    });
                                }
                                
                            });
                        })
                        .catch(() => {
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
                this.temporary_storage_limit = "";
                this.storage_limit_ext = "";
                this.form.id = "";
                this.form.name = "";
                this.form.email = "";
                this.form.role = "";
                this.form.permissions = [];
                this.form.storage_limit = "";
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

        permissionsValue(data){
            if(data){
                return data.join(', ');
            }
            return data;
        },

        storageLimitValue(value){
            if(value == null){
                return value = '0';
            }else {

                if(value != 0){
                    var i = Math.floor( Math.log(value) / Math.log(1024) );
                return ( value / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
            }
            if(value == 0){
                return value = '0';
            }else{
                return value = value;
            }
                }
        },

        temporaryStorageLimitValue(value) {
            if (value == 0) return "0";
            if(value > 0){
                var sizes = ['Bytes', 'kb', 'mb', 'gb', 'tb'];
                var sizes2 = Math.round(value / Math.pow(1024, i), 2) + '' + sizes[i];
                var i = Math.floor( Math.log(value) / Math.log(1024) );
                var answer = ( value / Math.pow(1024, i) ).toFixed(2) * 1 + '' + sizes[i];
                var inNumber = answer.slice(0, -2);
                var ext = answer.substr(answer.length - 2);
                // console.log(ext, inNumber);
                this.storage_limit_ext = ext;

                return inNumber;
            }if(value == 0){
                return value = '0';
            }else {
                return value = value;
            }
        },

        roleValue(value){
             
            if(value === null){
                return value = 'null';
            }else if(value === 1){
                return value = 'Админ';
            }else if(value === 0){
                return value = 'Энгийн хэрэглэгч';
            }else if(value === 2){
                return value = 'Дотоод ажилтан';
            }else{
                return value === 'Хоосон'
            }
        },

         handleClose(done) {
            console.log(done);
            this.$confirm('Үйлдлийг цуцлах уу?')
            .then(_ => {
                this.cancelDetail();
                done();
            })
            .catch(_ => {});
        }

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
    background: #84A4C1 !important;
    color: white;
    text-transform: uppercase;
    font-size: 0.9em;
    line-height: auto;
  }

</style>