<template>
    <div
        class="container mt-3"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
        <el-card class="container blog-div">
            <h4>Блог</h4>
            <!-- <el-divider></el-divider> -->
                <el-carousel indicator-position="outside">
                    <el-carousel-item v-for="(blog,index) in blogs.slice(0, 3)" :key="index">
                        <div class="item">
                            <div class="item__content">
                            {{blog.name}}
                            </div>
                            <img class="item__image" :src="blog.download" alt="" />
                        </div>
                    </el-carousel-item>
                </el-carousel>
            <div class="row">
                <div class="col-sm-12 col-md-4 mt-3" v-for="(blog,index) in blogs.slice(3)" :key="index">
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
        </el-card>
        <el-card class="file-div mt-3">
            <div class="container">
                <h4 class="mt-2">Файл</h4>
                <div class="mt-1">
                    <div class="custom-table-container">
                        <table class="custom-table">
                            <thead style="border-bottom: 1px solid black;">
                                <tr>
                                    <th class="grey">#</th>
                                    <th class="grey">Нэр</th>
                                    <th class="grey">Хэмжээ</th>
                                    <th class="grey">Огноо</th>
                                    <th class="grey">Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(file, index) in files" :key="index">
                                    <td class="grey">{{index + 1}}</td>
                                    <td>{{file.name}}</td>
                                    <td>{{readableSize(file.size)}}</td>
                                    <td>{{dateformatter(file.created_at)}}</td>
                                    <td>
                                        <el-button  @click="downloadFile(file.url, file.download)" type="success" icon="el-icon-download" class="float-left" circle size="small" plain></el-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </el-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            blogs: [],
            files:[],
            videos:[],
            posters:[]
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
                    this.videos = response.data[2];
                    this.posters = response.data[3];
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
        downloadFile(url, download) {
            var link = document.createElement("a");
            link.setAttribute('download', url);
            link.href = download;
            document.body.appendChild(link);
            link.click();
            link.remove();
        },
        handleTab(tab, event){
            console.log(tab, event);
        }
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
    width: 250px; 
    overflow: hidden;
    text-overflow: ellipsis; 
    /* border: 1px solid #000000; */
}
.custom-card-title2{
    margin-top: 1.2em;
    font-size: 1em;
    white-space: nowrap; 
    width: 240px; 
    overflow: hidden;
    text-overflow: ellipsis; 
    /* border: 1px solid #000000; */
}
.el-divider{
    margin-top: -0em;
}
/* .custom-table tr{
    border-style:hidden;
    
}
.custom-table thead{
    border-bottom: 1px solid black !important;
} */
.custom-table{
    width: 100%;
    text-align: left;
}
.custom-table thead{
    margin-bottom: 2em;
}
.custom-table table {border-collapse: collapse; border-spacing: 0;}
.custom-table tbody th, .custom-table tbody td {padding: 0.45em 0.75em;}
.custom-table thead th, .custom-table thead td {padding: 2em 0.75em;}
.custom-table thead th {border-bottom: 1px solid silver; text-align: left; font-weight: bold;}
.custom-table-container{
    max-height: 40em;
    overflow-y: scroll;
}
.file-div{
    background-color: #f8f8f9;
    padding: 0;
    margin: 0;
}
.item {
  position: relative;
  height: 100%;
}

.item__content {
  position: absolute;
  bottom: 0;
  width: 100%;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.5);
  color: #fff;
  padding: 3px;
}

.item__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: #d3dce6;
}
</style>
