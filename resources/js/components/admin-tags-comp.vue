<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <el-tabs v-model="activeTab" @tab-click="handleClick">
        <el-tab-pane label="ШИНЭ" name="new">
        <el-form>
            <el-form-item>
                <el-select v-model="form.name" placeholder="Select"
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
                <el-button type="primary" plain @click="postForm('new')">Хадгалах</el-button>
            </el-form-item>
        </el-form>

        </el-tab-pane>
        <el-tab-pane label="ЗАСАХ" name="edit">ЗАСАХ</el-tab-pane>
        <el-tab-pane label="УСТГАХ" name="delete">УСТГАХ</el-tab-pane>
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
        },
        handleClick(tab, event) {
            console.log(tab);
        }
    },
    created() {
        this.fetch();
    },
    // props:['permissions']
};
</script>
