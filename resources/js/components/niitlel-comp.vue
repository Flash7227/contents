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
                <el-row >
                    <!-- Nittlel -->
                    <el-col :span="6" v-for="(niitlel, ind) in niitlelData" :key="ind">
                        <el-card :body-style="{ padding: '0px' }" >
                          <div class="demo-image__preview">
                            <el-image 
                            style="width: 300px; height:300px" 
                            :src="niitlel.download"
                            :preview-src-list="[niitlel.download]">
                            </el-image>
                          </div>
                           <div style="padding: 10px;">
                              
                                <div slot="reference" class="name-wrapper" >
                                    <span size="medium">{{ niitlel.name }}</span>
                                </div>
                             
                              <div class="bottom clearfix">
                              <template >
                                <i class="el-icon-time"></i>
                                <span style="margin-left: 10px">{{ dateformatter(niitlel.created_at) }}</span>
                              </template>
                              <el-button type="text" class="button">Нийтлэл</el-button>
                              </div>
                          </div>
                        </el-card>
                    </el-col> 
                    
                </el-row>
            </el-main>
        </el-container>
    </div> 
</template>
<script>
 export default {
    data () {
      return {
        niitlelData:{},
        url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
        ]
      }
    },
    methods: {
      getNiitlelData(){
        axios
        .get("/home/niitlel/fetch")
        .then((response) => {
            this.loading = false;
            this.niitlelData = response.data;
            console.log(this.niitlelData);
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
      setLoading() {
        this.loading = true
        setTimeout(() => (this.loading = false), 2000)
      },
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClick(tab, event) {
        console.log(tab, event);
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
        this.getNiitlelData();
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