<template>
    <div
        class="container mt-3"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
        <div class="container blog-div">
            <h4 class="custom-title">Постер</h4>
            <el-carousel :interval="4000" type="card" height="350px">
                <el-carousel-item v-for="(poster,index) in posters" :key="index">
                    <div class="item" @click="addCount(poster.id, 'view')" >
                        <div class="item__content">
                            {{poster.name}}
                        </div>
                        <!-- <img class="item__image el-image__preview" :src="poster.download" alt=""  @click="addCount(poster.id, 'view')" :preview-src-list="[poster.download]"/> -->
                        <el-image class="item__image custom-hover" :src="poster.download" :preview-src-list="[poster.download]" fit="contain"></el-image>
                    </div>
                </el-carousel-item>
            </el-carousel>
            <div class="text-center mt-3">
                <el-button round @click="customHref('/home/poster')" type="primary" plain>Бүх постерыг үзэх  ↓</el-button>
            </div>
        </div>
        
        <el-card class="mt-3">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h4 class="custom-title">Нийтлэл</h4>
                    <table class="table">
                        <tr v-for="(blog, index) in blogs" :key="index">
                            <td class="text-left"><p style="font-size: 0.8;">{{blog.name}}</p>
                            </td>
                            <td class="text-right">
                                <el-button @click="viewBlog(blog)" circle icon="el-icon-view" type="primary" plain></el-button>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center mt-3">
                        <el-button round @click="customHref('/home/blog')" type="primary" plain>Бүх нийтлэлийг үзэх  ↓</el-button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h4 class="custom-title">Бичлэг</h4>
                    <table class="table">
                        <tr v-for="(video, index) in videos" :key="index">
                            <td class="text-left">{{video.name}}</td>
                            <td class="text-right">
                                <el-button @click="selectRow(video)" circle icon="el-icon-view" type="primary" plain></el-button>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center mt-3">
                        <el-button round @click="customHref('/home/video')" type="primary" plain>Бүх бичлэгүүдийг үзэх  ↓</el-button>
                    </div>
                </div>
            </div>
        </el-card>
        <el-card class="file-div mt-3">
            <div class="container">
                <h4 class="mt-1 custom-title">Файл</h4>
                <div>
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
                                        <el-button  @click="downloadFile(file.url, file.download, file.id)" type="success" icon="el-icon-download" class="float-left" circle size="small" plain></el-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <el-button round @click="customHref('/home/file')" type="primary" plain>Бүх файлуудыг үзэх  ↓</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </el-card>
        <el-dialog
            title="Үзэх"
            :visible.sync="viewVisible"
            width="90%"
            append-to-body
            :before-close="handleCloseView">
            <video width="90%" height="auto" controls ref="video" >
                <source :src="selected.download" type="video/mp4" ref="source1"/>
                <source :src="selected.download" :type="getExt(selected.url)" ref="source2"/>
                Your browser does not support the video tag.
            </video>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            viewVisible: false,
            blogs: [],
            files:[],
            videos:[],
            posters:[],
            selected:{
                type:"",
                url:"",
                download:""
            }
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
        addCount(id, type) {
            var url = "/counter/view/";
            if(type == 'download'){
                url = "/counter/download/";
            }
            axios
                .get(url+id)
                .then((response) => {
                })
                .catch((error) => {
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
        downloadFile(url, download, id) {
            var link = document.createElement("a");
            link.setAttribute('download', url);
            link.href = download;
            document.body.appendChild(link);
            link.click();
            link.remove();
            this.addCount(id, 'download');
        },
        handleTab(tab, event){
            console.log(tab, event);
        },
        getExt(raw){
            // console.log(raw);
            var url = raw.split('.');
            return 'video/'+url[url.length - 1];
        },
        selectRow(data){
            this.selected.type = data.type;
            this.selected.url = data.url;
            this.selected.download = data.download;
            this.addCount(data.id, 'view');
            this.viewdata();
        },
        handleCloseView(){
            if(this.selected.type == 2){
                var video = this.$refs.video;
                video.play();
                video.pause();
                // video.currentTime = 0;
            }
            this.viewVisible = false;         
        },
        async viewdata() {
            this.viewVisible = true;
            if(this.selected.type == 2){
                this.loading = true;
                const result = await this.viewAfter();
            }
        },
        viewAfter() {
            return new Promise(resolve => {
                setTimeout(() => {
                this.loading = false;
                    var video = this.$refs.video;
                    var source1 = this.$refs.source1;
                    var source2 = this.$refs.source2;
                    source1.setAttribute('src', this.selected.download);
                    source2.setAttribute('src', this.selected.download);
                    video.load();
                }, 1000);
            });
        },
        viewBlog(data){
            location.href = '/blog/' + data.id;
        },
        tagFinder(id){
            if(id){
                var filtered = (JSON.parse(this.tags)).filter(
                    (tag) => tag.id == id
                );
                // console.log(filtered);
                if (filtered[0]) {
                    return filtered[0].name;
                } else {
                    return "TAG NOT FOUND!";
                }
            }
            
        }
    },
    created() {
        this.fetch();
    },
    props: {
        csrf: {
            type: String,
        },
        tags: {
            type: String,
        },
    }
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
.custom-table thead th, .custom-table thead td {padding: 1.5em 0.75em;}
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
  z-index: 1;
}

.item__image {
  object-fit: contain;
  margin-bottom: 30px;
  opacity: 0.9;
  z-index: 0.8;
}

.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: #d3dce6;
}
.custom-hover:hover{
    cursor: pointer;
    opacity: 1;
    transition: 0.3s;
}
.custom-title{
    color: #84A4C1;
}
</style>
