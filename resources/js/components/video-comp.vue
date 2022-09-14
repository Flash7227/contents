<template>
<div class="container">
  <el-container>
      <el-main>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <el-form :inline="true" class="text-center" size="mini">
              <el-form-item label="Нэр">
                  <div class="block">
                  <el-input v-model="search.name" placeholder="нэрээр хайх"></el-input>
                  </div>
              </el-form-item>
              <el-form-item label="#Tag" prop="tags">
                <el-select v-model="search.tag" placeholder="Select"
                    multiple
                    filterable>
                    <el-option
                      v-for="(dbtag,index) in (Dbtags)"
                      :key="index"
                      :label="dbtag.name"
                      :value="dbtag.id"
                      >
                    </el-option>
                </el-select>
              </el-form-item>
              <el-form-item>
                <div class="block">
                  <span class="demonstration">Огноо</span>
                  <el-date-picker
                  v-model="search.date"
                  type="daterange"
                  align="right"
                  start-placeholder="Start Date"
                  end-placeholder="End Date"
                  default-value="2022-01-01">
                  </el-date-picker>
                </div>
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

          <div class="col-lg-4 col-md-4 col-sm-4 rowspaceb " v-for="(video, index) in videoData.data" :key="index">
            <video
              style="width: 100%; height: 200px;"
              :kind="'video'"
              :isMuted="false"
              :src="video.download"
              :autoplay="false"
              :controls="true"
              :loop="true"
              width="auto"
             
            ></video>
              <div>
                <span class="overme">{{video.name}}</span>
                <el-button style="float: right; padding: 3px 0; color: #409EFF; font-size: 1.3em" @click="selectRow(video), submitView(video,  'countView')" type="text"  size="medium" icon="el-icon-view"></el-button>
                <el-button
                  style="float: right; padding: 3px 0"
                  size="medium"
                  type="text"
                  circle
                  @click="handleDownload(video.url, video.download), submitView(video, 'countDownload')"><i class="el-icon-download" style="color: #67C23A; font-size: 1.3em"></i>
                </el-button>
              </div>
              <div>
                <el-tag 
                  size="mini" 
                  type="info"
                  v-for="(tag,index) in JSON.parse(video.tags)"
                  :key="index"
                >{{tagName(tag)}}</el-tag>
              </div>
              <time class="time" style="float: left">{{ dateformatter(video.created_at) }}</time>
          </div>
          
        </div>  
        <pagination
            :data="videoData"
            @pagination-change-page="searchFunc"
            :limit="3"
            align="center"
            class="my-2"
          ></pagination>
          <el-dialog
          class="text-center"
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
      Dbtags: [],
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
          this.videoData = response.data[0];
          this.Dbtags = response.data[1];
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
      .post("/home/count", {data: data, count})
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
    tagName(id){
      if(id){
        // console.log(id);
        var filtered = (this.Dbtags).filter(
            (tag) => tag.id == id
        );
        //console.log(filtered);
        if (filtered[0]) {
            return filtered[0].name;
        }else{
          return "TAG NOT FOUND!";
        }
      }
    }
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
  element.style {
      width: 100%;
      height: 200px;
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