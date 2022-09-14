<template>
    <div class="container" style="text-align:center">
        <el-container>
            <el-main>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="rowspace">
                            <el-card>
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
                                    <el-form-item label="Огноо">
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
                                    <small class="grey">Нийт: {{ filesData.total }}</small>
                                </div> 
                                <el-table
                                    header-cell-class-name="my-header"
                                    style="text-align: center; width: 100%"
                                    class="card"
                                    :data="filesData.data"
                                    border
                                    size="small">
                                    <el-table-column
                                    label="Төрөл"
                                    width="120"
                                    align="center">
                                    <template slot-scope="scope">
                                    
                                        <div slot="reference" class="name-wrapper">
                                            <span v-if="scope.row.type === 1" size="medium">Файл</span>
                                            <span v-if="scope.row.type === 2" size="medium">Видео</span>
                                            <span v-if="scope.row.type === 3" size="medium">Зураг</span>
                                        </div>
                                    </template>
                                    </el-table-column>
                                    <el-table-column
                                    label="Нэр"
                                    align="center">
                                    <template slot-scope="scope">
                                        <div slot="reference" class="name-wrapper">
                                            <span size="medium">{{ scope.row.name }}</span>
                                        </div>
                                    </template>
                                    </el-table-column>
                                    <el-table-column
                                    prop="tags"
                                    label="Түлхүүр үг/tag"
                                    align="center"
                                    >
                                    <template slot-scope="scope">
                                        <el-tag
                                        type="info"
                                        class="mr-1 mb-1"
                                        v-for="(tag, index) in JSON.parse(scope.row.tags)"
                                        :key="index"
                                        disable-transitions>
                                            {{tagName(tag)}}
                                        </el-tag>
                                    </template>
                                    </el-table-column>
                                    <el-table-column
                                    label="Огноо"
                                    width="180"
                                    align="center">
                                    <template slot-scope="scope">
                                        <i class="el-icon-time"></i>
                                        <span style="margin-left: 10px">{{ dateformatter(scope.row.created_at) }}</span>
                                    </template>
                                    </el-table-column>
                                    <el-table-column
                                        label="Үйлдэл"
                                        width="90"
                                        align="center">
                                        <template slot-scope="scope">
                                            <el-button
                                            v-if="scope.row.type === 3 || scope.row.type === 2"
                                            size="small"
                                            type="info"
                                            round
                                            @click="toView(scope.row.download), pickDetails(scope.row), submitView(scope.row,  'countView'), dialogVisible = true
                                            "><i class="el-icon-view"></i>
                                            </el-button>
                                            <el-button
                                            size="small"
                                            type="success"
                                            round
                                            @click="handleDownload(scope.row.url, scope.row.download), submitView(scope.row,  'countDownload')"><i class="el-icon-download"></i>
                                            </el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                                <pagination
                                    :data="filesData"
                                    @pagination-change-page="searchFunc"
                                    :limit="1"
                                    align="center"
                                    class="my-2"
                                ></pagination>
                            </el-card>
                        </div>
                    </div>
                    <el-dialog
                       :title="selected.name"
                        :visible.sync="dialogVisible"
                        width="60%"
                        destroy-on-close
                        :before-close="handleClose">
                        <span>
                            <el-image 
                                :src="selected.download" 
                                :preview-src-list="[selected.download]"
                                >
                            </el-image>
                            <video
                                ref="video" 
                                class="video" 
                                width="100%" 
                                controls>
                                <source :src="selected.download" type="video/mp4">
                            </video>
                        </span>
                        <span slot="footer" class="dialog-footer">
                            <el-button @click="dialogVisible = false">Cancel</el-button>
                            <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
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
        dialogVisible: false,
        filesData:{},
        Dbtags:[],
        selected: {
            file: '',
            created_at:'',
            download:'',
            id:'',
            name:'',
            size:'',
            desc: '',
            // tags:'',
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
      }
    },
    methods: {
      getfilesData(page=1){
        axios
        .get("/home/file/fetch?page=" + page)
        .then((response) => {
            this.loading = false;
            this.filesData = response.data[0];
            this.Dbtags = response.data[1];
            console.log(this.filesData);
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
        axios.post("/home/file/fetchSearch", { search: this.search})
            .then((response) => {
                this.loading = false;
                if(response.data[0]){
                    console.log(response.data);
                    this.filesData = response.data[0];
                }else{
                    console.log(response.data);
                    this.getfilesData();
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
         toView(dwnld){
            console.log(dwnld);
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
            this.selected.name = data.name;
            this.selected.size = data.size;
            this.selected.desc = data.desc;
            // this.types.tags = data.tags;
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
        },

        dateformatter(date, short) {
            if (short) {
                // console.log(short, '---');
                return moment(date).format("YYYY-MM-DD");
            } else {
                return moment(date).format("YYYY-MM-DD HH:mm");
            }
        },
        handleClose(done) {
            this.$confirm('Are you sure to close this dialog?')
            .then(_ => {
                done();
            })
            .catch(_ => {});
        },
      
    },
    created() {
        this.getfilesData();
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
 .rowspace{
    padding: 10px;
    margin-top: 20px
  }
</style>