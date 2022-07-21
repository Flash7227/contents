<template>
    <div class="container">
        <el-card>
            <el-table
            style="text-align: center; width: 100%"
            class="card"
            :data="data"
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
                    width="400"
                    align="center">
                    <template slot-scope="scope">
                        <el-button
                        v-if="scope.row.type === 3 || scope.row.type === 2"
                        size="medium"
                        type="info"
                        plain
                        @click="toView(scope.row.download), pickDetails(scope.row), dialogVisible = true
                        ">үзэх
                        </el-button>
                        <el-button
                        size="medium"
                        type="success"
                        plain
                        @click="handleDownload(scope.row.url, scope.row.download)">татах
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
    </div>
  
</template>

<script>
export default {
    data(){
        return{
            dialogVisible: false,
            data: [],
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
    methods:{
        fetch() {
            axios.post("/user/shared/fetch")
                .then((response) => {
                    this.data = response.data.data;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.$notify.error({
                        title: "Error",
                        message: error.response.data.message,
                    });
                });
        },

        // forceFileDownload(response, title) {
        //     console.log(response, title)
        //     const url = window.URL.createObjectURL(new Blob([response.data]))
        //     const link = document.createElement('a')
        //     link.href = url
        //     link.setAttribute('download', title)
        //     document.body.appendChild(link)
        //     link.click()
        // },

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
        this.fetch();
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

.card {
    text-align: center;
}

</style>