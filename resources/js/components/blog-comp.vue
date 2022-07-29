<template>
  <div class="container">
    <el-container>
      <el-main>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12"  style="text-align:center">
            <el-form :inline="true">
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
              <small class="grey">Нийт: {{ blogData.total }}</small>
            </div> 
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 rowspace" v-for="(blog, index) in blogData.data" :key="index" >
            <!-- <el-card :body-style="{ padding: '0px' }" > -->
              <div class="readIcon" v-if="blog.url=='noimage123.png'">
                <i class="el-icon-reading"></i>
              </div>
              <div class="demo-image__preview" v-else >
                <el-image 
                  style="width: 100%; height: 270px; border-radius: 8px"
                  :src="blog.download" 
                  :preview-src-list=[blog.download]>
                </el-image>
              </div>
              <div style="padding: 14px;" class="description">
                <div class="custom-card-title overme">
                   <!-- <a v-bind:href="'/home/blog/details/'+ blog.id">{{blog.name}}</a> -->
                   <el-button @click="viewBlog(blog)" type="text"></el-button>
                </div>
                <small class="grey">{{dateformatter(blog.created_at, false)}}</small>
              </div>
            <!-- </el-card> -->
          </div>
          <pagination
            :data="blogData"
            @pagination-change-page="getData"
            :limit="6"
            align="center"
            class="my-2"
          ></pagination> 
        </div>
              
       
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
      </el-main>
    </el-container>
  </div> 
</template>
<script>
 export default {
    data () {
      return {
        centerDialogVisible: false,
        blogData:{},
        selected:{},
        search: {
          name:'',
          date:'',
          tag: ''
        }
      }
    },
    methods: {
      getData(page=1){
        axios
        .get("/home/blog/fetch?page="+page)
        .then((response) => {
            this.loading = false;
            this.blogData = response.data;
            console.log(this.blogData);
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
      axios.post("/home/blog/fetchSearch", { search: this.search})
        .then((response) => {
            this.loading = false;
            if(response.data[0]){
                console.log(response.data);
                this.blogData = response.data[0];
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
      viewBlog(data){
          location.href = '/home/blog/' + data.id;
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
  .el-image{
    display: block;
  }
  .image {
    width: 100%;
    height: 250px;
    display: block;
  }
  .readIcon{
    width: 100%;
    height: 250px;
    background-color: #0B5394;
    text-align: center; 
    font-size: 8em; 
    color: #FF9900 
  }
  .description{
    width: 100%;
    height: 150px;
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
  .overme {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    text-align: left;
}
</style>