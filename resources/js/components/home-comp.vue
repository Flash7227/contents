<template>
<div class="container">
  <el-container style="text-align:center">
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
          </el-col>
        </el-row>
        <!-- Нийтлэл -->
        <el-row :gutter="20">
          <el-col :span="24">
            <el-col :span="6" v-for="(niitlel, index) in niitlels" :key="index" >
              <div  class="glass">
                <h3><i class="el-icon-tickets" style="font-size: 2em; color: #ffff"></i></h3>
                <p style="font-size: 1em; color: #ffff;">Нийтлэл</p>
                <!-- <el-link @click="pickDetails(niitlel), dialogVisible = true" type="warning">{{niitlel.name}}</el-link> -->
                 <el-link @click="pickDetails(niitlel), dialogVisible = true" :underline="false" style="font-size: 10px; color: #ffff;">{{niitlel.name}}</el-link>
                  <time class="time">{{dateformatter(niitlel.created_at)}}</time>
                <el-dialog
                  :title=selected.name
                  append-to-body
                  :visible.sync="dialogVisible"
                  width="80%"
                  :before-close="handleClose">
                  <span v-html="selected.desc"></span>
                  <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">Хаах</el-button>
                  </span>
                </el-dialog>
              </div>
            </el-col>
          </el-col>
        </el-row>
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
                <!-- <span>Card name</span> -->
                <el-button style="float: left; padding: 3px 0" type="default" icon="el-icon-edit"> Постер</el-button>
              </div>
              <div>
                  <el-table
                    :data="posters"
                    style="width: 100%">
                    <el-table-column type="expand">
                      <template slot-scope="scope">
                         <p> URL: {{ scope.row.url }}</p>
                        <el-button
                          size="small"
                          type="success"
                          round
                          @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                          </el-button>
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
                <el-button style="float: right; padding: 3px 0" type="default" icon="el-icon-files"> Файл</el-button>
              </div>
              <div>
                <el-table
                    :data="files"
                    style="width: 100%">
                    <el-table-column type="expand">
                      <template slot-scope="scope">
                         <p> URL: {{ scope.row.url }}</p>
                        <el-button
                          size="small"
                          type="success"
                          round
                          @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                          </el-button>
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
        dialogVisible: false,
        files:{},
        videos:{},
        posters:{},
        niitlels:{},
        selected:{},
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

  
/* card image */
  .time {
    font-size: 13px;
    color: #E6A23C !important;
    text-align: left !important
  }
  
  /* .bottom {
    margin-top: 10px;
    line-height: 9px;
  } */

  
</style>