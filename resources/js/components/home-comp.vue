<template>
<div class="container">
  <el-container>
      <el-main>
        <div class="row" style="text-align: center;">
          <div class="col-lg-12 col-md-12 col-sm-12 rowspace">
            <div>
              <el-carousel :interval="4000" type="card">
                  <el-carousel-item v-for="(poster, item) in posters" :key="item">
                    <img
                    width="100%"
                    height="100%"
                    :src="poster.download"
                    :preview-src-list="[poster.download]"
                  />
                  </el-carousel-item>
              </el-carousel>
            </div>
            <div>
              <el-badge is-dot class="item" type="warning">
                <el-button onclick="location.href='/home/video'" size="small">Бичлэг</el-button>
              </el-badge>
              <el-badge is-dot class="item" type="primary">
                <el-button onclick="location.href='/home/niitlel'" size="small">Нийтлэл</el-button>
              </el-badge>
              <el-badge is-dot class="item" type="warning">
                <el-button onclick="location.href='/home/poster'" size="small">Постер</el-button>
              </el-badge>
              <el-badge is-dot class="item" type="primary">
                <el-button onclick="location.href='/home/file'" size="small">Файл</el-button>
              </el-badge>
            </div>
          </div>
          <!-- Нийтлэл -->
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(niitlel, index) in niitlels" :key="index">
            <el-card :body-style="{ padding: '0px' }" >
              <div class="readIcon" v-if="niitlel.url=='noimage123.png'">
                <i class="el-icon-reading"></i>
              </div>
              <div v-else>
                <img 
                  class="image"
                  :src="niitlel.download"
                  :preview-src-list="[niitlel.download]"/>
              </div>
              <div style="padding: 14px;">
                <p class="overme">{{niitlel.name}}</p>
                <div class="bottom clearfix">
                  <time class="time">{{dateformatter(niitlel.created_at)}}</time>
                  <el-button 
                  :hidden="niitlel.url=='noimage123.png' ? true:false"
                  icon="el-icon-download"  
                  size="small" type="success" 
                  circle 
                  class="button" 
                  @click="handleDownload(niitlel.url, niitlel.download)">
                  </el-button>
                  <el-button icon="el-icon-view"  size="small" circle class="button" @click="pickDetails(niitlel), centerDialogVisible = true" ></el-button>
                </div>
              </div>
            </el-card>
          </div>
          <!-- Бичлэг -->
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(video, index) in videos" :key="index">
            <Media
              style="width: 300px; height: 200px;"
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
            <div style="padding: 1px;">
              <span style="text-align: left;">{{video.name}}</span>
              <div class="bottom clearfix">
                <time class="time">{{ dateformatter(video.created_at) }}</time>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 rowspace">
            <!-- Постер -->
            <el-card class="box-card">
              <div>
                <div slot="header" class="clearfix">
                  <el-button onclick="location.href='/home/poster'" size="small" style="float: right;">
                    <i class="el-icon-picture-outline"></i>Постер
                  </el-button>
                </div>
                <el-table
                  :data="posters"
                  style="width: 100%">
                  <el-table-column 
                  type="expand">
                    <template slot-scope="scope">
                      <p> Татах:
                        <el-button
                          size="small"
                          type="success"
                          round
                          @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                        </el-button>
                      </p>
                    </template>
                  </el-table-column>
                  <el-table-column
                    label="Огноо"
                  >
                  <template slot-scope="scope">
                    <span size="medium">{{ dateformatter(scope.row.created_at)}}</span>
                  </template>
                  </el-table-column>
                  <el-table-column
                    label="Нэр">
                    <template slot-scope="scope">
                      <span size="medium">{{ scope.row.name }}</span>
                    </template>
                  </el-table-column>
                </el-table>
              </div>
            </el-card>
          </div>
          <!-- Файл -->
          <div class="col-lg-6 col-md-6 col-sm-6 rowspace">
            <el-card class="box-card">
            <div>
              <div slot="header" class="clearfix">
                <el-button onclick="location.href='/home/file'" size="small" style="float: right;">
                  <i class="el-icon-document"></i>Файл
                </el-button>
                </div>
              <el-table
                :data="files"
                style="width: 100%">
                <el-table-column type="expand">
                  <template slot-scope="scope">
                      <p> Татах:
                        <el-button
                          size="small"
                          type="success"
                          round
                          @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                        </el-button>
                      </p>  
                  </template>
                </el-table-column>
                <el-table-column
                  label="Огноо"
                >
                <template slot-scope="scope">
                  <span size="medium">{{ dateformatter(scope.row.created_at)}}</span>
                </template>
                </el-table-column>
                <el-table-column
                  label="Нэр">
                  <template slot-scope="scope">
                    <span size="medium">{{ scope.row.name }}</span>
                  </template>
                </el-table-column>
              </el-table>
            </div>
            </el-card>
            <el-dialog
              :title="selected.name"
              :visible.sync="centerDialogVisible"
              width="90%"
              center>
              <span v-html="selected.desc">
              </span>
              <span slot="footer" class="dialog-footer">
                <el-button @click="centerDialogVisible = false">Хаах</el-button>
              </span>
            </el-dialog>
          </div>
        </div>
    </el-main>
  </el-container>
  </div>
</template>

<script>
import Media from "@dongido/vue-viaudio";

  export default {
    data () {
      return {
        centerDialogVisible: false,
        files:[],
        videos:{},
        posters:[],
        niitlels:{},
        selected:{
          file: '',
          created_at:'',
          download:'',
          desc:'',
          id:'',
          name:'',
          size:'',
          tags:'',
          type:'',
          updated_at:'',
          url:'',
          user_id:'',
        },
      }
    },
    methods: {
      handleClose(){
          this.dialogVisible = false;         
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
      pickDetails(data){
        this.selected.file = data.file;
        this.selected.created_at = data.created_at;
        this.selected.download = data.download;
        this.selected.id = data.id;
        this.selected.desc = data.desc;
        this.selected.name = data.name;
        this.selected.size = data.size;
        this.selected.tags = JSON.parse(data.tags);
        this.selected.type = data.type;
        this.selected.updated_at = data.updated_at;
        this.selected.url = data.url;
        this.selected.user_id = data.user_id;
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
    font-size: 14px;
    opacity: 0.75;
    line-height: 400px;
    /* width: 540px;
    height: 400px; */
    margin: 0;
  }
  /* .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  } */
  
  .time {
    font-size: 13px;
    color: #999;
  }
  
  .bottom {
    margin-top: 13px;
    line-height: 12px;
    
  }

  .button {
    padding: 0;
    float: right;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  
  .clearfix:after {
      clear: both
  }
  .image {
    width: 100%;
    height: 200px;
    display: block;
  }
  .readIcon{
    width: 100%;
    height: 200px;
    background-color: #0B5394;
    text-align: center; 
    font-size: 8em; 
    color: #FF9900 
  }

  .rowspace{
    padding: 10px;
  }
  
</style>