<template>
    <div class="container" style="text-align:center">
        <el-container>
            <el-main>
              <el-row :gutter="20">
                <el-col :span="24">
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
              <el-row :span="20" justify="space-around">
                <el-form :inline="true" label-width="90px">
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
                <el-col :span="6" v-for="(niitlel, index) in uploadData.data" :key="index" style="padding: 1px; color: #ffff">
                  <div class="glass">
                    <h3><i class="el-icon-tickets" style="font-size: 2em; color: #ffff"></i></h3>
                    <p style="font-size: 1em; color: #ffff;">Нийтлэл</p>
                     <el-link @click="pickDetails(niitlel), dialogVisible = true" :underline="false" style="font-size: 10px; color: #ffff;">{{niitlel.name}}</el-link>
                    <time class="time">{{dateformatter(niitlel.created_at)}}</time>
                    <el-dialog
                      :title=selected.name
                      append-to-body
                      :visible.sync="dialogVisible"
                      width="100%"
                      :before-close="handleClose">
                      <span v-html="selected.desc"></span>
                      <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogVisible = false">Хаах</el-button>
                      </span>
                    </el-dialog>
                  </div>
                </el-col>
              </el-row>
              <pagination
                :data="uploadData"
                @pagination-change-page="getData"
                :limit="1"
                align="center"
                class="my-2"
            ></pagination>
            </el-main>
        </el-container>
    </div> 
</template>
<script>
 export default {
    data () {
      return {
        dialogVisible: false,
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

</style>