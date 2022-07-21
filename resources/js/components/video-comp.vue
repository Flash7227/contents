<template>
    <div class="container">
        <el-container>
          <el-header>
            <el-breadcrumb separator=" ">
              <el-breadcrumb-item ><a href="/home/niitlel"><el-button size="mini" round>Нийтлэл</el-button></a></el-breadcrumb-item>
              <el-breadcrumb-item ><a href="/home/poster"><el-button size="mini" round>Постер</el-button></a></el-breadcrumb-item>
              <el-breadcrumb-item ><a href="/home/video"><el-button size="mini" round>Бичлэг</el-button></a></el-breadcrumb-item>
              <el-breadcrumb-item ><a href="/home/file"><el-button size="mini" round>Файл</el-button></a></el-breadcrumb-item>
            </el-breadcrumb>
          </el-header>
            <el-main>
                <el-row>
                    <!-- video -->
                    <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0" >
                      <!-- <el-card :body-style="{ padding: '0px' }"> -->
                        <Media
                          :kind="'video'"
                          :isMuted="false"
                          :src="'https://www.w3schools.com/html/mov_bbb.mp4'"

                          :autoplay="true"
                          :controls="true"
                          :loop="true"
                          @pause="handle"
                          :ref="'video_player'"
                          width="auto"
                          ></Media>
                        <div style="padding: 10px;">
                          <span style="text-align: left; font-weight: bold;">bunny bear and butterfly</span>
                          <div class="bottom clearfix">
                            <time class="time">{{ currentDate }}</time>
                          </div>
                        </div>
                      <!-- </el-card> -->
                    </el-col>
                    <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0" >
                      <!-- <el-card :body-style="{ padding: '0px' }"> -->
                        <Media
                          :kind="'video'"
                          :isMuted="false"
                          :src="'https://www.w3schools.com/html/mov_bbb.mp4'"

                          :autoplay="true"
                          :controls="true"
                          :loop="true"
                          @pause="handle"
                          :ref="'video_player'"
                          width="auto"
                          ></Media>
                        <div style="padding: 10px;">
                          <span style="text-align: left; font-weight: bold;">bunny bear and butterfly</span>
                          <div class="bottom clearfix">
                            <time class="time">{{ currentDate }}</time>
                          </div>
                        </div>
                      <!-- </el-card> -->
                    </el-col>
                    <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0" >
                      <!-- <el-card :body-style="{ padding: '0px' }"> -->
                        <Media
                          :kind="'video'"
                          :isMuted="false"
                          :src="'https://www.w3schools.com/html/mov_bbb.mp4'"

                          :autoplay="true"
                          :controls="true"
                          :loop="true"
                          @pause="handle"
                          :ref="'video_player'"
                          width="auto"
                          ></Media>
                        <div style="padding: 10px;">
                          <span style="text-align: left; font-weight: bold;">bunny bear and butterfly</span>
                          <div class="bottom clearfix">
                            <time class="time">{{ currentDate }}</time>
                          </div>
                        </div>
                      <!-- </el-card> -->
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
      currentDate: new Date()
    };
  },
  components: {
    Media,
  },
  name: "Example",
  methods: {
    handle() {
      setTimeout(() => {
        //this.$refs.video_player.play();
      },);
    },
  },
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

</style>