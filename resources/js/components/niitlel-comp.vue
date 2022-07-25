<template>
  <div class="container" style="text-align:center">
    <el-container>
      <el-main>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 rowspace">
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
          </div>
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
              <p style="text-align:left">Нийт: {{ uploadData.total }}</p>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(niitlel, index) in uploadData.data" :key="index" >
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
          <pagination
            :data="uploadData"
            @pagination-change-page="getData"
            :limit="6"
            align="center"
            class="my-2"
          ></pagination>           
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
        </div>
      </el-main>
    </el-container>
  </div> 
</template>
<script>
 export default {
    data () {
      return {
        centerDialogVisible: false,
        uploadData:{},
        selected:{},
        search: {
          name:'',
          date:''
        }
      }
    },
    methods: {
      getData(page=1){
        axios
        .get("/home/niitlel/fetch?page="+page)
        .then((response) => {
            this.loading = false;
            this.uploadData = response.data;
            console.log(this.uploadData);
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
        axios.post("/home/niitlel/fetchSearch", { search: this.search})
          .then((response) => {
              this.loading = false;
              if(response.data[0]){
                  console.log(response.data);
                  this.uploadData = response.data[0];
              }else{
                  console.log(response.data);
                  this.getData();
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
      
      handleClose(){
          this.dialogVisible = false;         
      },
      
      dateformatter(date, short) {
        if (short) {
            // console.log(short, '---');
            return moment(date).format("YYYY-MM-DD");
        } else {
            return moment(date).format("YYYY-MM-DD HH:mm");
        }
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
    },
    created() {
        this.getData();
    },
    mounted(){
    },
    props: {
        csrf: {
            type: String,
        },
    }
 }
</script>


<style>
  .time {
    font-size: 13px;
    color: #999;
  }
    
  .bottom {
    margin-top: 13px;
    line-height: 12px;
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

  .card {
    display: block;
    margin-left: auto;
    margin-right: auto
  }
  .el-image {
    border-radius: 5px 5px 0 0;
    text-align: center;
  }
  .el-row {
    margin-bottom: 20px;
    
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