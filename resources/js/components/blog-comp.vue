<template>
  <div class="container">
    <el-container>
      <el-main>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12"  style="text-align:center">
            <el-form :inline="true" size="mini">
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
                  end-placeholder="End Date">
                  </el-date-picker>
                </div>
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
          <div class="col-lg-4 col-md-4 col-sm-4 " v-for="(blog, index) in blogData.data" :key="index" >
            <div class="demo-image__preview" >
              <el-image 
                style="width: 100%; height: 270px; border-radius: 8px"
                :src="blog.download" 
                :preview-src-list=[blog.download]>
              </el-image>
            </div>
            <div style="padding: 8px;" class="description">
              <div class="custom-card-title overme">
                <el-button @click="viewBlog(blog), submitView(blog, 'countView')" type="text" class="overme">{{blog.name}}</el-button>
              </div>
              <div>
                <el-tag 
                  size="mini" 
                  type="info"
                  v-for="(tag,index) in JSON.parse(blog.tags)"
                  :key="index"
                >{{tagName(tag)}}</el-tag>
              </div>
              
                <small class="grey">{{dateformatter(blog.created_at, false)}}</small>
            </div>
            
          </div>
          
        </div>
        <pagination
            :data="blogData"
            @pagination-change-page="searchFunc"
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
        Dbtags:[],
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
            this.blogData = response.data[0];
            this.Dbtags = response.data[1];
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
      searchFunc(page=1){
      axios.post("/home/blog/fetchSearch?page="+page, { search: this.search})
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
      viewBlog(data){
          location.href = '/blog/' + data.id;
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
    /* height: 150px; */
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