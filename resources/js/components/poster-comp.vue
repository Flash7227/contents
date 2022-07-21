<template>
    <div class="container">
        <el-container>
            <el-main>
                <el-row>
                    <!-- poster -->
                    <el-col :span="18" style="padding: 10px;">
                        <el-card >
                        <div>
                            <el-divider content-position="left">
                            <el-badge :value="12" class="item">
                                <el-button type="default" icon="el-icon-tickets">ПОСТЕР</el-button>
                            </el-badge>
                            </el-divider> 
                            <span> 
                            <!-- <template slot-scope="scope">
                                {{scope.row.name}}
                            </template> -->
                            </span>
                            <span>What you are you do not see, what you see is your shadow.</span>
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