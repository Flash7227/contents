<template>
    <div class="container">
      <el-container>
        <el-header class="container">
            <el-breadcrumb separator=" ">
            <el-breadcrumb-item ><a href="/home/niitlel"><el-button size="mini" round>Нийтлэл</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/poster"><el-button size="mini" round>Постер</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/video"><el-button size="mini" round>Бичлэг</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/file"><el-button size="mini" round>Файл</el-button></a></el-breadcrumb-item>
            </el-breadcrumb>
        </el-header>
          <el-main>
            <!-- video -->
            <el-row>
              <el-col :span="8" v-for="video in videoData" :key="video">
                <Media
                  style="width: 350px; height: 200px"
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
            </el-row>
          </el-main>
      </el-container>
    </div> 
</template>
<script>
import Media from "@dongido/vue-viaudio";

export default {
  data() {
    return {
      videoData:{},
      currentDate: new Date()
    };
  },
  components: {
    Media,
  },
  name: "Example",
  methods: {
    getvideoData(){
      axios
      .get("/home/video/fetch")
      .then((response) => {
          this.loading = false;
          this.videoData = response.data;
          console.log(this.videoData);
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
  },
  created() {
        this.getvideoData();
    },
    mounted(){
    },
    props: {
        csrf: {
            type: String,
        },
    }
};
</script>

<style>
  .example {
    text-align: center;
    
  }
  .Media {
    width: 100%;
    height: auto;
  }
  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }
  .clearfix:after {
      clear: both
  }
  .time {
    font-size: 13px;
    color: #999;
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