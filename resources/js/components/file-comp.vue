<template>
    <div class="container">
        <el-container>
            <!-- <el-header class="container">
            <el-breadcrumb separator=" ">
            <el-breadcrumb-item ><a href="/home/niitlel"><el-button size="mini" round>Нийтлэл</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/poster"><el-button size="mini" round>Постер</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/video"><el-button size="mini" round>Бичлэг</el-button></a></el-breadcrumb-item>
            <el-breadcrumb-item ><a href="/home/file"><el-button size="mini" round>Файл</el-button></a></el-breadcrumb-item>
            </el-breadcrumb>
        </el-header> -->
            <el-main>
                <el-card>
                    <el-table
                    style="text-align: center; width: 100%"
                    class="card"
                    :data="filesData"
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
                                @click="toView(scope.row.download), pickDetails(scope.row), dialogVisible = true
                                "><i class="el-icon-view"></i>
                                </el-button>
                                <el-button
                                size="small"
                                type="success"
                                round
                                @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                                </el-button>

                                <el-dialog
                                    title="Tips"
                                    :visible.sync="dialogVisible"
                                    width="60%"
                                    destroy-on-close
                                    :before-close="handleClose">
                                    <span>
                                        <el-image 
                                            v-if="scope.row.download === types.download"
                                            :src="types.download" 
                                            :preview-src-list="[types.download]"
                                            >
                                        </el-image>
                                        <video
                                            v-if="scope.row.download === types.download"
                                            ref="video" 
                                            class="video" 
                                            width="100%" 
                                            controls>
                                            <source :src="scope.row.download" type="video/mp4">
                                        </video>
                                    </span>
                                    <span slot="footer" class="dialog-footer">
                                        <el-button @click="dialogVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="dialogVisible = false">Confirm</el-button>
                                    </span>
                                </el-dialog>
        
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
                <!-- <pagination
                    :data="filesData"
                    @pagination-change-page="getfilesData"
                    :limit="1"
                    align="center"
                    class="my-2"
                ></pagination> -->
            </el-main>
            
        </el-container>
    </div> 
</template>
<script>
 export default {
    data () {
      return {
        dialogVisible: false,
        filesData:[],
        types: {
            file: '',
            created_at:'',
            download:'',
            id:'',
            name:'',
            size:'',
            // tags:'',
            type:'',
            updated_at:'',
            url:'',
            user_id:'',
        }
      }
    },
    methods: {
      getfilesData(){
        axios
        .get("/home/file/fetch")
        .then((response) => {
            this.loading = false;
            this.filesData = response.data;
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
            
            this.types.file = data.file;
            this.types.created_at = data.created_at;
            this.types.download = data.download;
            this.types.id = data.id;
            this.types.name = data.name;
            this.types.size = data.size;
            // this.types.tags = data.tags;
            this.types.type = data.type;
            this.types.updated_at = data.updated_at;
            this.types.url = data.url;
            this.types.user_id = data.user_id;
                
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