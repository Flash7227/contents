<template>
<div class="container">
  <el-container>
      <el-main>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <el-form :inline="true" class="text-center">
              <el-form-item label="Нэр">
                  <div class="block">
                  <el-input v-model="search.name" placeholder="нэрээр хайх"></el-input>
                  </div>
              </el-form-item>
              <el-form-item label="#Tag">
                <div class="block">
                    <el-input v-model="search.tag" placeholder="тагаар хайх"></el-input>
                </div>
              </el-form-item>
              <el-form-item label="Огноо">
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
            <hr>
            <div class="text-right">
              <small class="grey">Нийт: {{ videoData.total }}</small>
            </div> 
          </div>
           <!-- Бичлэг -->

          <div class="col-lg-4 col-md-4 col-sm-4 rowspaceb text-center" v-for="(video, index) in videoData.data" :key="index">
            <video
              style="width: 300px; height: 200px;"
              :kind="'video'"
              :isMuted="false"
              :src="video.download"
              :autoplay="false"
              :controls="true"
              :loop="true"
              width="auto"
             
            ></video>
            <div style="padding: 1px">
              <span>{{video.name}}</span>
              <div class="bottom clearfix">
              <time class="time" style="float: left">{{ dateformatter(video.created_at) }}</time>
              <div style="float: right">
                <el-button @click="selectRow(video), submitView(video,  'countView')" type="text"  size="medium" icon="el-icon-view" style="color: #409EFF; font-size: 1.3em"></el-button>
                <el-button
                  size="medium"
                  type="text"
                  circle
                  @click="handleDownload(video.url, video.download), submitView(video, 'countDownload')"><i class="el-icon-download" style="color: #67C23A; font-size: 1.3em"></i>
                </el-button>            
              </div>
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
          <el-dialog
            title="Үзэх"
            :visible.sync="viewVisible"
            width="90%"
            append-to-body
            :before-close="handleCloseView">
            <video width="90%" height="auto" controls ref="video" >
                <source :src="selected.download" type="video/mp4" ref="source1"/>
                <source :src="selected.download" :type="getExt(selected.url)" ref="source2"/>
                Your browser does not support the video tag.
            </video>
        </el-dialog>
    </el-main>
  </el-container>
  </div>
</template>
<script>

export default {
  data() {
    return {
      videoData:{},
      viewVisible: false,
      selected: {
        file: '',
        created_at:'',
        download:'',
        id:'',
        name:'',
        size:'',
        desc:'',
        type:'',
        updated_at:'',
        url:'',
        user_id:'',
      },
      search: {
          name:'',
          tag: '',
          date:'',
      }
    };
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
    submitView(data, count) {
      console.log(count,data);
      // var countDownload = count;
      // var countView = count;
      axios
      .post("/user/count", {data: data, count})
      .then((response) => {
          this.loading = false;
          if(response.data == 'success'){
              this.resetForm();
              this.$message({
                  message: "Successful",
                  type: "success",
                  duration: 3000,
              });
              this.fetch();
          }
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
    getExt(raw){
      // console.log(raw);
      var url = raw.split('.');
      return 'video/'+url[url.length - 1];
    },
    selectRow(data){
      this.selected.type = data.type;
      this.selected.url = data.url;
      this.selected.download = data.download;
      this.viewdata();
    },
    async viewdata() {
      this.viewVisible = true;
      if(this.selected.type == 2){
          this.loading = true;
          const result = await this.viewAfter();
      }
    },
    viewAfter() {
      return new Promise(resolve => {
          setTimeout(() => {
          this.loading = false;
              var video = this.$refs.video;
              var source1 = this.$refs.source1;
              var source2 = this.$refs.source2;
              source1.setAttribute('src', this.selected.download);
              source2.setAttribute('src', this.selected.download);
              video.load();
          }, 1000);
      });
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