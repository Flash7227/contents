<template>
<div class="container">
  <el-container style="text-align:center">
      <el-main>
        <div class="row">
          <!-- <div class="col-lg-12 col-md-12 col-sm-12 rowspace">
            <el-badge is-dot class="item" type="success">
              <el-button onclick="location.href='/home'" size="small">Нүүр</el-button>
            </el-badge>
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
          </div> -->
          <div class="col-lg-12 col-md-12 col-sm-12">
            <el-form :inline="true">
              <el-form-item label="нэр">
                  <div class="block">
                  <el-input v-model="search.name" placeholder="нэрээр хайх"></el-input>
                  </div>
              </el-form-item>
              <el-form-item label="огноо">
                  <el-date-picker
                      v-model="search.date"
                      type="date"
                      :localTime="false"
                      format="yyyy-MM-dd"
                      value-format="yyyy-MM-dd"
                      placeholder="огноогоор хайх"
                      :clearable="true">
                  </el-date-picker>
              </el-form-item>
              <el-form-item>
                  <el-button type="primary" icon="el-icon-search" @click="searchFunc"></el-button>
              </el-form-item>
            </el-form>
            <p style="text-align:left">Нийт: {{ videoData.total }}</p>
          </div>
           <!-- Бичлэг -->

          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(video, index) in videoData.data" :key="index">
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
          
        </div>  
        <pagination
            :data="videoData"
            @pagination-change-page="getvideoData"
            :limit="3"
            align="center"
            class="my-2"
          ></pagination>
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
      search: {
          name:'',
          date:''
      }
    };
  },
  components: {
    Media,
  },
  name: "Example",
  methods: {
    getvideoData(page=1){
      axios
      .get("/home/video/fetch?page="+page)
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
    searchFunc(){
      axios.post("/home/video/fetchSearch", { search: this.search})
        .then((response) => {
          this.loading = false;
          if(response.data[0]){
              console.log(response.data);
              this.videoData = response.data[0];
          }else{
              console.log(response.data);
              this.getvideoData();
          }
        })
        .catch((error) => {
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
  .rowspace{
    padding: 10px;
    margin-top: 20px
  }

</style>