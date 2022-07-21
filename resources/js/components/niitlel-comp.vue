<template>
    <div class="container">
        <el-container>
            <el-main>
                <el-row>
                    <!-- Nittlel -->
                    <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0">
                        <el-card :body-style="{ padding: '0px' }" >
                        <div class="demo-image__preview">
                            <el-image 
                            style="width: 300px; height:300px" 
                            :src="url"
                            :preview-src-list="srcList">
                            </el-image>
                        </div>
                        <div style="padding: 10px;">
                            <span>
                            <!-- <template slot-scope="scope"> -->
                                <!-- {{data.name}} -->
                            <!-- </template> -->
                            </span>
                            <div class="bottom clearfix">
                            <!-- <time class="time">{{uploadData.data.name}}</time> -->
                            <el-button type="text" class="button">Нийтлэл</el-button>
                            </div>
                        </div>
                        </el-card>
                    </el-col>
                    <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0">
                        <el-card :body-style="{ padding: '0px' }" >
                        <div class="demo-image__preview">
                            <el-image 
                            style="width: 300px; height:300px" 
                            :src="url"
                            :preview-src-list="srcList">
                            </el-image>
                        </div>
                        <div style="padding: 10px;">
                            <span>
                           fhfg
                            </span>
                            <div class="bottom clearfix">
                            fdgfg
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
        loading: true,
        currentDate: '2021-06-01',
        lists: [],
        activeIndex: '',
        activeName: '',
        uploadData:{},
         url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
        ]
      }
    },
    methods: {
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
      getNiitlel(page=1){
        axios
        .get("/home/getupload?page=1")
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
      }
    },
    created() {
        this.getNiitlel();
    },
 }
</script>