<template>
    <div class="container">
      <!-- <el-header class="container">
            <el-breadcrumb separator=" ">
            <el-breadcrumb-item ><a href="/home/niitlel"><el-button size="mini" round>Нийтлэл</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/poster"><el-button size="mini" round>Постер</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/video"><el-button size="mini" round>Бичлэг</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/file"><el-button size="mini" round>Файл</el-button></a></el-breadcrumb-item>
            </el-breadcrumb>
        </el-header> -->
        <el-container>
            <el-main>
              <el-row class="row-bg" justify="space-around" style="text-align: center">
                <el-col :span="6" v-for="(niitlel, ind) in niitlelData" :key="ind" style="margin: 0.3cm">
                  <div class="grid-content bg-purple">
                    <el-card :body-style="{ padding: '0px' }" class="card">
                      <el-image 
                        style="width: 300px; height:300px;" 
                        :src="niitlel.download"
                          :preview-src-list="[niitlel.download]">
                      </el-image>
                      <div style="padding: 10px;">
                        <span style="text-align: left; font-weight: bold;">{{niitlel.name}}</span>
                        <div class="bottom clearfix">
                          <time class="time">{{ dateformatter(niitlel.created_at) }}</time>
                            <el-button type="text" class="button" @click="handleDownload(niitlel.url, niitlel.download)"><i class="el-icon-download"></i></el-button>
                        </div>
                      </div>
                    </el-card>
                  </div>
                </el-col>
              </el-row>
                
            </el-main>
        </el-container>
    </div> 
</template>
<script>
 export default {
    data () {
      return {
        niitlelData:{},
        url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
        ]
      }
    },
    methods: {
      getNiitlelData(){
        axios
        .get("/home/niitlel/fetch")
        .then((response) => {
            this.loading = false;
            this.niitlelData = response.data;
            console.log(this.niitlelData);
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
      setLoading() {
        this.loading = true
        setTimeout(() => (this.loading = false), 2000)
      },
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClick(tab, event) {
        console.log(tab, event);
      },
      
      dateformatter(date, short) {
          if (short) {
              // console.log(short, '---');
              return moment(date).format("YYYY-MM-DD");
          } else {
              return moment(date).format("YYYY-MM-DD HH:mm");
          }
      },
      handleDownload(urlz, downloadz) {
        var url = urlz;
        var download = downloadz;
        var link = document.createElement("a");
        link.setAttribute('download', url);
        link.href = download;
        console.log(url, link.href);
        var a = document.body.appendChild(link);
        link.click();
        link.remove();
      },
    },
    created() {
        this.getNiitlelData();
    },
    mounted(){
    },
    props: {
        csrf: {
            type: String,
        },
    }
 }
</script>


<style>
  .time {
    font-size: 13px;
    color: #999;
  }
    
  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  
  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  
  .clearfix:after {
    clear: both
  }

  .card {
    display: block;
    margin-left: auto;
    margin-right: auto
  }
  .el-image {
    border-radius: 5px 5px 0 0;
    text-align: center;
  }
  .el-row {
    margin-bottom: 20px;
    
  }

  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
  }

</style>