<template>
    <div
        class="container mt-5"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
        <h4>Блог</h4>
        <el-divider></el-divider>
        <div class="row">
            <div class="col-sm-12 col-md-4 mt-3" v-for="(blog,index) in blogs" :key="index">
                <el-card :body-style="{ padding: '0px' }">
                    <img :src="blog.download" class="image">
                </el-card>
                <div class="custom-card-title">
                    {{blog.name}}
                </div>
                <small class="grey">{{dateformatter(blog.created_at, false)}}</small>
            </div>
        </div>
        <div class="text-center mt-3">
            <el-button round @click="customHref('/home/blog')">Бүх постыг үзэх  ↓</el-button>
        </div>
        <div>
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Файл</th>
                        <th>Хэмжээ</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(file, index) in files" :key="index">
                        <td>{{index + 1}}</td>
                        <td>{{file.name}}</td>
                        <td>{{readableSize(file.size)}}</td>
                        <td><el-button>download</el-button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            blogs: [],
            files:[]
        };
    },
    methods: {
        fetch() {
            this.loading = true;
            axios
                .get("/home/fetch")
                .then((response) => {
                    this.loading = false;
                    this.blogs = response.data[0];
                    this.files = response.data[1];
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
        dateformatter(date, short) {
            if (short) {
                // console.log(short, '---');
                return moment(date).format("YYYY-MM-DD");
            } else {
                return moment(date).format("YYYY-MM-DD HH:mm");
            }
        },
        customHref(url)
        {
            location.href = url;
        },
        readableSize(size){
            if(size != 0){
                var i = Math.floor( Math.log(size) / Math.log(1024) );
                return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
            }        
        },
    },
    created() {
        this.fetch();
    },
    // props:['permissions']
};
</script>
<style scoped>
.custom-card-title{
    margin-top: 1.5em;
    font-size: 1.1em;
    white-space: nowrap; 
    width: 300px; 
    overflow: hidden;
    text-overflow: ellipsis; 
    /* border: 1px solid #000000; */
}
.el-divider{
    margin-top: -0em;
}
.custom-table{
    border-style:hidden;
}
</style>
