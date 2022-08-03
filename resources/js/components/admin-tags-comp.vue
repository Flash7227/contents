<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <el-tabs v-model="activeTab" @tab-click="handleClick">
        <el-tab-pane label="ШИНЭ" name="new">
            <el-card  class="text-left">
                <p>ШИНЭ TAG ҮҮСГЭХ</p>
                <el-form label-width="120px">
                    <el-form-item>
                        <el-select v-model="form.name" placeholder="Утга оруулах"
                            filterable
                            allow-create
                            default-first-option>
                            <el-option
                            v-for="(tag,index) in tags"
                            :key="index"
                            :label="tag.name"
                            :value="tag.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" plain @click="postForm('new')">ҮҮСГЭХ</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-tab-pane>
        <el-tab-pane label="ЗАСАХ" name="edit">
            <el-card  class="text-left">
                <p>TAG ЗАСАХ</p>
                <el-form label-width="120px">
                    <el-form-item label="Засах TAG">
                        <el-select v-model="form.name" placeholder="Утга сонгох"
                            filterable>
                            <el-option
                            v-for="(tag,index) in tags"
                            :key="index"
                            :label="tag.name"
                            :value="tag.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Шинэ утга" v-if="form.name">
                        <el-input placeholder="ШИНЭ УТГА" v-model="form.input2"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="info" plain @click="postForm('edit')">ЗАСАХ</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-tab-pane>
        <el-tab-pane label="УСТГАХ" name="delete">
            <el-card  class="text-left">
                <p>TAG УСТГАХ</p>
                <el-form label-width="120px">
                    <el-form-item>
                        <el-select v-model="form.name" placeholder="Утга сонгох"
                            filterable
                            allow-create
                            default-first-option>
                            <el-option
                            v-for="(tag,index) in tags"
                            :key="index"
                            :label="tag.name"
                            :value="tag.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="danger" plain @click="postForm('delete')">УСТГАХ</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-tab-pane>
    </el-tabs>

    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            tags:[],
            activeTab:"new",
            form:{
                name:"",
                input2:"",
                type:"new"
            }
        };
    },
    methods: {
        fetch() {
            this.loading = true;
            axios
                .get("/admin/tags/fetch")
                .then((response) => {
                    this.loading = false;
                    this.tags = response.data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error.response);
                    this.$notify.error({
                        title: "Error",
                        message: error.response.data.message,
                    });
                });
        },
        postForm(type) {
            this.$confirm('Итгэлтэй байна уу?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                this.form.type = type;
                axios
                    .post("/admin/tags", {form:this.form})
                    .then((response) => {
                        this.loading = false;
                        if(response.data == "success"){
                            this.$notify({
                                title: 'Success',
                                message: 'Амжилттай!',
                                type: 'success'
                            });
                            this.resetForm();
                            this.fetch();
                        }
                    })
                    .catch((error) => {
                        this.loading = false;
                        console.log(error.response);
                        this.$notify.error({
                            title: "Error",
                            message: error.response.data.message,
                        });
                    });
            }).catch(() => {
                // this.$message({
                //     type: 'info',
                //     message: 'Delete canceled'
                // });          
            });
        },
        resetForm(){
            this.form.name = "";
            this.form.input2 = "";
        },
        handleClick(tab, event) {
            // console.log(tab);
        }
    },
    created() {
        this.fetch();
    },
    // props:['permissions']
};
</script>
