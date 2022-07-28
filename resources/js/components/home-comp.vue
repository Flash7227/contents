<template>
<div class="container">
  <el-container>
      <el-main>
        <div class="row" style="text-align: center;">
          <div class="col-lg-12 col-md-12 col-sm-12 rowspace">
            <div>
              <!-- <el-carousel height="600px" width="100%" direction="vertical" :autoplay="false">
                <el-carousel-item v-for="(poster, index) in posters" :key="'d'+index" >
                  <el-image 
                    style="width: 100%; height: 600px"
                    :src="poster.download" 
                    :preview-src-list=[poster.download]>
                  </el-image>
                </el-carousel-item>
              </el-carousel> -->
              <!-- <el-carousel :interval="4000" type="card">
                  <el-carousel-item v-for="(poster, index) in posters" :key="'b'+index" >
                    <div class="demo-image__preview">
                      <el-image 
                        style="width: 100%; height: 300px"
                        :src="poster.download" 
                        :preview-src-list=[poster.download]>
                      </el-image>
                    </div>
                  </el-carousel-item>
              </el-carousel> -->
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 rowspace" >
            <el-table
              :data="posters"
              height="250"
              style="width: 100%">
              <el-table-column
                label="огноо">
                <template slot-scope="scope">
                  <span size="medium">{{ dateformatter(scope.row.created_at)}}</span>
                </template>
              </el-table-column>
              <el-table-column
                label="Name">
                <template slot-scope="scope">
                  <span size="medium">{{scope.row.name}}</span>
                </template>
              </el-table-column>
              <el-table-column
              label="Үйлдэл"
              width="100"
              align="center">
              <template slot-scope="scope">
                  <el-button
                  size="small"
                  type="success"
                  circle
                  @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                  </el-button>
              </template>
            </el-table-column>
            </el-table>
            
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 rowspace">
            <el-table
              :data="files"
              height="250"
              style="width: 100%">
              <el-table-column
                label="огноо">
                <template slot-scope="scope">
                  <span size="medium">{{ dateformatter(scope.row.created_at)}}</span>
                </template>
              </el-table-column>
              <el-table-column
                label="Name">
                <template slot-scope="scope">
                  <span size="medium">{{scope.row.name}}</span>
                </template>
              </el-table-column>
              <el-table-column
              label="Үйлдэл"
              width="100"
              align="center">
              <template slot-scope="scope">
                  <el-button
                  size="small"
                  type="success"
                  circle
                  @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                  </el-button>
              </template>
            </el-table-column>
            </el-table>
            <div style="width: 100%" class="rowspace">
             <h1 style="float: left; font-style: bold;">Шинэ Нийтлэл</h1>
            </div>
            <div style="width: 100%" class="rowspace">
             <hr>
            </div>
             
            
          </div>
          
          <!-- Нийтлэл -->
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(niitlel, index) in niitlels" :key="'c'+index">
            <el-card :body-style="{ padding: '0px' }" style="border-radius: 8px" >
              <div class="readIcon" v-if="niitlel.url=='noimage123.png'">
                <i class="el-icon-reading"></i>
              </div>
              <div class="demo-image__preview" v-else >
                <el-image 
                  style="width: 100%; height: 270px; border-radius: 8px"
                  :src="niitlel.download" 
                  :preview-src-list=[niitlel.download]>
                </el-image>
              </div>
              <div style="padding: 14px;">
                <div>
                  <p class="overme">{{niitlel.name}}</p>
                  <!-- <el-button @click="pickDetails(niitlel), centerDialogVisible = true" type="text" class="overme">{{niitlel.name}}</el-button> -->
                </div>
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
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(video, index) in videos" :key="'a'+index">
            <Media
              width="100%"
              height="200px"
              :kind="'video'"
              :isMuted="false"
              :src="video.download"
              :autoplay="false"
              :controls="true"
              :loop="true"
              @pause="handle"
              :ref="'video_player'"
              class="example"
            ></Media>
            <div style="padding: 1px;">
              <span style="text-align: left;">{{video.name}}</span>
              <div class="bottom clearfix">
                <time class="time">{{ dateformatter(video.created_at) }}</time>
              </div>
            </div>
              <!-- <el-card :body-style="{ padding: '0px' }">
                <Media
                  width="100%"
                  height="200px"
                  :kind="'video'"
                  :isMuted="false"
                  :src="video.download"
                  :autoplay="false"
                  :controls="true"
                  :loop="true"
                  @pause="handle"
                  :ref="'video_player'"
                  class="example"
                ></Media>
                <div style="padding: 14px;">
                  <span >{{video.name}}</span>
                  <div class="bottom clearfix">
                    <time class="time">{{ dateformatter(video.created_at) }}</time>
                  </div>
                </div>
              </el-card> -->
          </div>
            
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
    display: block;
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
  .el-image{
    display: block;
  }
  .image {
    width: 100%;
    height: 300px;
    display: block;
  }
  .readIcon{
    width: 100%;
    height: 270px !important;
    background-color: #0B5394;
    text-align: center !important; 
    font-size: 13em !important; 
    border-radius: 8px;
    color: #FF9900 
  }

  .rowspace{
    padding: 10px;
  }
  .home-card{
    height: 320px;
  }
</style>