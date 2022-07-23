<template>
    <div class="container" style="text-align:center">
        <el-container>
            <el-main>
              <el-row justify="space-around">
                <el-col :span="6" v-for="(niitlel, index) in uploadData.data" :key="index">
                  <div class="glass">
                    <h3><i class="el-icon-tickets" style="font-size: 2em; color: #ffff"></i></h3>
                    <p style="font-size: 1em; color: #ffff;">Нийтлэл</p>
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
              </el-row>
              <pagination
                :data="uploadData"
                @pagination-change-page="getData"
                :limit="6"
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