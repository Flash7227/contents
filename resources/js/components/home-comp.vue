<template>
  <div class="container">
    <el-header class="container">
      <el-breadcrumb separator=" ">
      <el-breadcrumb-item ><a href="/home/niitlel"><el-button size="mini" round>Нийтлэл</el-button></a></el-breadcrumb-item>
      <el-breadcrumb-item ><a href="/home/poster"><el-button size="mini" round>Постер</el-button></a></el-breadcrumb-item>
      <el-breadcrumb-item ><a href="/home/video"><el-button size="mini" round>Бичлэг</el-button></a></el-breadcrumb-item>
      <el-breadcrumb-item ><a href="/home/file"><el-button size="mini" round>Файл</el-button></a></el-breadcrumb-item>
      </el-breadcrumb>
    </el-header>
    <el-container>
      <el-main>
        <!-- <el-carousel indicator-position="outside">
          <el-carousel-item v-for="(niitlel, item) in niitlels" :key="item">
            <el-image 
              style="width: 700px; height:300px;" 
              :src="niitlel.download"
                :preview-src-list="[niitlel.download]">
            </el-image>
          </el-carousel-item>
        </el-carousel> -->
        <el-carousel :interval="4000" type="card" height="200px">
          <el-carousel-item v-for="(niitlel, item) in niitlels" :key="item">
            <el-image 
              :src="niitlel.download"
                :preview-src-list="[niitlel.download]">
            </el-image>
          </el-carousel-item>
        </el-carousel>
        <el-row>
          <!-- Nittlel -->
          <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0">
            <el-card :body-style="{ padding: '0px' }" >
              <div class="demo-image__preview">
                <el-image 
                  style="width: 300px; height:300px" 
                  :src="url"
                  :preview-src-list="srcList">
                </el-image>
              </div>

              <div style="padding: 10px;">
                <span>
                  <!-- <template slot-scope="scope"> -->
                      <!-- {{data.name}} -->
                  <!-- </template> -->
                </span>
                <div class="bottom clearfix">
                  <!-- <time class="time">{{uploadData.data.name}}</time> -->
                  <el-button type="text" class="button">Нийтлэл</el-button>
                </div>
              </div>
            </el-card>
          </el-col>
          <!-- poster -->
          <el-col :span="18" style="padding: 10px;">
            <el-card >
              <div>
                <el-divider content-position="left">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-tickets">ПОСТЕР</el-button>
                  </el-badge>
                </el-divider> 
                <span> 
                  <!-- <template slot-scope="scope">
                    {{scope.row.name}}
                  </template> -->
                </span>
                <span>What you are you do not see, what you see is your shadow.</span>
              </div>
            </el-card>
          </el-col>
          <!-- file -->
          <el-col :span="6" style="padding: 10px;" >
            <el-card >
              <div>
                <el-divider content-position="right">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-files">ФАЙЛ</el-button>
                  </el-badge>
                </el-divider>
                <span>I cannot choose the best. The best chooses me.</span>
                <el-divider><i class="el-icon-star-on"></i></el-divider>
                <span>My wishes are fools, they shout across thy song, my Master. Let me but listen.</span>
                <el-divider content-position="right">Rabindranath Tagore</el-divider>
              </div>
            </el-card>
          </el-col>
          <!-- video -->
          <el-col :span="24" style="padding: 10px;" >
            <el-card >
              <div>
                <el-divider content-position="right">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-files">БИЧЛЭГ</el-button>
                  </el-badge>
                </el-divider>
                <video width="400" controls>
                  <source src="mov_bbb.mp4" type="video/mp4">
                  <source src="mov_bbb.ogg" type="video/ogg">
                  Your browser does not support HTML video.
                </video>
              </div>
            </el-card>
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
        activeIndex: '',
        activeName: '',
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
  .el-breadcrumb {
    border-bottom: solid 1px #475669; 
    /* border-top: solid 1px #475669; */
    padding: 10px;
    
  }
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