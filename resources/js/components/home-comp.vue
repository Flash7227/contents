<template>
<div class="container">
  <el-container>
      <el-main>
        <el-row :gutter="20">
          <el-col :span="24">
            <el-carousel :interval="4000" type="card" height="400px">
                <el-carousel-item v-for="(poster, item) in posters" :key="item">
                  <el-image 
                    :src="poster.download"
                    :preview-src-list="[poster.download]">
                  </el-image>
                </el-carousel-item>
            </el-carousel>
            <div style="text-align: center">
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
            
          </el-col>
        </el-row>
        <!-- Нийтлэл -->
        <!-- <el-row :gutter="20">
          <el-col :span="6" v-for="(niitlel, index) in niitlels" :key="index" >
            <div class="glass">
              <h3><i class="el-icon-reading" style="text-align: center; font-size: 2em; color: #ffff"></i></h3>
              <p style="text-align: center; font-size: 1em; color: #ffff;">Нийтлэл</p>
              <p style="font-size: 10px; color: #ffff;">{{niitlel.name}}</p>
              <time class="time">{{dateformatter(niitlel.created_at)}}</time>
              <span>
                <el-button icon="el-icon-view"  size="small" circle @click="pickDetails(niitlel), centerDialogVisible = true" ></el-button>
                <el-button icon="el-icon-view"  size="small" type="success" circle @click="handleDownload(niitlel.url, niitlel.download)"></el-button>
              </span>
            </div>
          </el-col>

        </el-row> -->

        <el-row>
          <el-col :span="6" v-for="(niitlel, index) in niitlels" :key="index">
            <el-card :body-style="{ padding: '0px' }" >
            <div class="icon">
              <i class="el-icon-reading"></i>
            </div>
              <div style="padding: 14px;">
                <span>{{niitlel.name}}</span>
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
          </el-col>
        </el-row>
        <el-dialog
          :title="selected.name"
          :visible.sync="centerDialogVisible"
          width="100%"
          center>
          <span v-html="selected.desc">
          </span>
          <span slot="footer" class="dialog-footer">
            <el-button @click="centerDialogVisible = false">Хаах</el-button>
          </span>
        </el-dialog>
        <!-- Бичлэг -->
        <el-row :gutter="20">
          <el-col :span="8" v-for="(video, index) in videos" :key="index">
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
          </el-col>
        </el-row>
        <el-row :glutter="20">
          <!-- Постер -->
          <el-col :span="14">
            <el-card class="box-card">
              <div slot="header" class="clearfix">
                <span style="float: left; padding: 3px 0;">
                  <i class="el-icon-picture-outline" ></i> ПОСТЕР
                </span>
              </div>
              <div>
                  <el-table
                    :data="posters"
                    style="width: 100%">
                    <el-table-column type="expand">
                      <template slot-scope="scope">
                         <p> URL: {{ scope.row.url }}</p>
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
          </el-col>
          <!-- Файл -->
          <el-col :span="10">
          <el-card class="box-card">
              <div slot="header" class="clearfix">
                <span style="float: right; padding: 3px 0;">
                  <i class="el-icon-files" ></i> ФАЙЛ
                </span>
              </div>
              <div>
                <el-table
                    :data="files"
                    style="width: 100%">
                    <el-table-column type="expand">
                      <template slot-scope="scope">
                         <p> URL: {{ scope.row.url }}</p>
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

          </el-col>
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
    line-height: 200px;
    margin: 0;
  }
  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
  
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

  .image {
    
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
  .icon{
    width: 100%;
    background-color: #0B5394;
   text-align: center; 
   font-size: 8em; 
   color: #FF9900 


  }

  
</style>