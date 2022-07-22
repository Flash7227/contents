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
        <el-carousel :interval="4000" type="card" height="200px">
          <el-carousel-item v-for="(niitlel, item) in niitlels" :key="item">
            <el-image 
              :src="niitlel.download"
              :preview-src-list="[niitlel.download]">
            </el-image>
          </el-carousel-item>
        </el-carousel>
        <el-row>
          <!-- Бичлэг -->
          <el-card>
            <el-col content-position="right">
              <el-badge value="шинэ" class="item">
                <el-button onclick="location.href='/home/video'" size="small" type="default" icon="el-icon-film">БИЧЛЭГ</el-button>
              </el-badge>
            </el-col>
            <el-col :span="8" v-for="(video, index) in videos" :key="index">
              <Media
                style="width: 300px; height: 200px"
                :kind="'video'"
                :isMuted="false"
                :src="video.download"
                :autoplay="false"
                :controls="true"
                :loop="true"
                @pause="handle"
                :ref="'video_player'"
                width="auto"
                class="example"
              ></Media>
              <div style="padding: 10px;">
                <span style="text-align: left; font-weight: bold;">{{video.name}}</span>
                <div class="bottom clearfix">
                  <time class="time">{{ dateformatter(video.created_at) }}</time>
                </div>
              </div>
            </el-col>

            <el-col :span="24" style="margin: 2px; padding-top: 5px;">
              
                <el-divider content-position="left">
                  <el-badge value="шинэ" class="item">
                    <el-button onclick="location.href='/home/niitlel'" size="small" type="default" icon="el-icon-tickets">Нийтлэл</el-button>
                  </el-badge>
                </el-divider> 
                <div v-for="(niitlel, index) in niitlels" :key="index" class="text item">
                <el-card shadow="hover">
                  <!-- <el-button type="text" @click="centerDialogVisible = true">{{niitlel.name}}</el-button>
                  <time class="time" style="float: right; padding: 3px 0">{{ dateformatter(niitlel.created_at) }}</time>
                  <el-dialog
                    title="Warning"
                    :visible.sync="centerDialogVisible"
                    width="850px"
                    center>
                    <span>{{niitlel.desc}}</span>
                  </el-dialog> -->

                  <el-button type="text" @click="dialog1 = true">{{niitlel.name}}</el-button>
  
                  <el-dialog
                    title="Нийтлэл"
                    append-to-body
                    :visible.sync="dialog1"
                    width="80%"
                    :before-close="handleClose">
                    <h3>{{niitlel.name}}</h3>
                    <p>{{niitlel.desc}}</p>
                    <span slot="footer" class="dialog-footer">
                      <el-button @click="dialogVisible = false">Cancel</el-button>
                      <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
                    </span>
                  </el-dialog>
                </el-card>
                  
                </div>
              
            </el-col>
            <!-- Постер -->
            <el-col class="col-md-12">
              <el-divider content-position="right"> 
                <el-badge value="шинэ" class="item">
                  <el-button onclick="location.href='/home/poster'"  size="small" type="default" icon="el-icon-files">ПОСТЕР</el-button>
                  </el-badge>
              </el-divider> 
              <el-col :span="6" v-for="(poster, ind) in posters" :key="ind" style="margin: 1cm">
                <div class="grid-content bg-purple">
                  <el-card :body-style="{ padding: '0px' }" class="card">
                    <el-image 
                       style="width: 300px; height: 250px;"
                      :src="poster.download"
                        :preview-src-list="[poster.download]">
                    </el-image>
                    <div style="padding: 10px;">
                      <span style="text-align: right; font-weight: bold;">{{poster.name}}</span>
                      <div class="bottom clearfix">
                        <time class="time">{{ dateformatter(poster.created_at) }}</time>
                          <el-button  size="small" type="success" class="button" @click="handleDownload(poster.url, poster.download)" circle><i class="el-icon-download"></i></el-button>
                      </div>
                    </div>
                  </el-card>
                </div>
              </el-col>
              <!-- Файл -->
              <!-- <el-col :span="6">
                <el-card  shadow="hover" style="padding: 2px">
                  <el-divider content-position="left"> 
                    <el-badge value="шинэ" class="item">
                      <el-button onclick="location.href='/home/file'" size="small" type="default" icon="el-icon-files">ФАЙЛ</el-button>
                      </el-badge>
                  </el-divider>
                  <div v-for="(file, index) in files" :key="index" class="text item">
                    <el-button type="text"  @click="handleDownload(file.url, file.download)">{{file.name}}</el-button>
                  </div>
                </el-card>
              </el-col> -->
            </el-col>
          </el-card>
          
        </el-row>
      </el-main>
    </el-container>
  </div> 
</template>

<script>
import Media from "@dongido/vue-viaudio";

  export default {
    data () {
      return {
        dialog1: false,
        files:{},
        videos:{},
        posters:{},
        niitlels:{},
         url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg',
          'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
        ]
      }
    },
    methods: {
      handleClose(){
          this.dialog1 = false;         
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
      handle() {
        setTimeout(() => {
          //this.$refs.video_player.play();
        },);
      },
      dateformatter(date, short) {
        if (short) {
            // console.log(short, '---');
            return moment(date).format("YYYY-MM-DD");
        } else {
            return moment(date).format("YYYY-MM-DD HH:mm");
        }
      },
      getUpload(){
        axios
        .get("/home/getupload")
        .then((response) => {
            this.loading = false;
            this.files = response.data[0];
            this.videos = response.data[1];
            this.posters = response.data[2];
            this.niitlels = response.data[3];
        })
        .catch((error) => {
            this.loading = false;
            console.log(error.response);
            this.$notify.error({
                title: "Error",
                message: error.response.data.message,
            });
        });
      }
    },
    created() {
        this.getUpload();
    },
  }

</script>

<style>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }

  .text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    width: 1000px;
  }

/* card image */
  .time {
    font-size: 13px;
    color: #999;
  }
  
  .bottom {
    margin-top: 10px;
    line-height: 9px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  
  .clearfix:after {
      clear: both
  }
</style>