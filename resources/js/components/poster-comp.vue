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
                        <el-card class="rowspace">
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
                            <p style="text-align:left">Нийт: {{ postersData.total }}</p>
                            <el-table
                            style="text-align: center; width: 100%"
                            class="card"
                            :data="postersData.data"
                            border>
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
                                    width="100"
                                    align="center">
                                    <template slot-scope="scope">
                                        <!-- <el-button
                                        size="small"
                                        circle
                                        @click="pickDetails(scope.row), centerDialogVisible = true
                                        "><i class="el-icon-view"></i>
                                        </el-button> -->
                                        <el-button icon="el-icon-view" size="small" circle class="button" @click="pickDetails(scope.row), centerDialogVisible = true" ></el-button>

                                        <el-button
                                        size="small"
                                        type="success"
                                        circle
                                        @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                                        </el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <pagination
                                :data="postersData"
                                @pagination-change-page="getPosterData"
                                :limit="1"
                                align="center"
                                class="my-2"
                            ></pagination>
                        </el-card>
                    </div>
                </div>
                
                <el-dialog
                    :title="selected.name"
                    :visible.sync="centerDialogVisible"
                    width="60%">
                    <span>
                        <el-image 
                            :src="selected.download" 
                            :preview-src-list="[selected.download]"
                            >
                        </el-image>
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
        postersData:{},
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
            date:''
        }
      }
    },
    methods: {
      getPosterData(page=1){
        axios
        .get("/home/poster/fetch?page=" + page)
        .then((response) => {
            this.loading = false;
            this.postersData = response.data;
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
        axios.post("/home/poster/fetchSearch", { search: this.search})
            .then((response) => {
                this.loading = false;
                if(response.data[0]){
                    console.log(response.data);
                    this.postersData = response.data[0];
                }else{
                    console.log(response.data);
                    this.getPosterData();
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
        this.getPosterData();
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