<template>
    <div class="container">
        <el-card>
            <el-table
            style="text-align: center; width: 100%"
            class="card"
            :data="data">
                
                <el-table-column
                label="Name"
                width="180">
                <template slot-scope="scope">
                   
                    <div slot="reference" class="name-wrapper">
                        <span size="medium">{{ scope.row.name }}</span>
                    </div>
                    
                </template>
                </el-table-column>
                <el-table-column
                label="Огноо"
                width="180">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span style="margin-left: 10px">{{ moment(scope.row.created_at).format('YYYY-MM-DD-HH:MM') }}</span>
                </template>
                </el-table-column>
                <el-table-column
                label="Operations">
                <template slot-scope="scope">
                    <!-- <el-button
                    size="medium"
                    type="info"
                    plain
                    @click="handleDownload(scope.row, scope.row.name)">үзэх</el-button> -->
                    <el-button
                    size="medium"
                    type="info"
                    plain
                    @click="handleDownload(scope.row, scope.row.name)">татах</el-button>
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

            data: []
        }

    },
    methods:{
        fetch() {
            axios.post("/user/shared/fetch")
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.$notify.error({
                        title: "Error",
                        message: error.response.data.message,
                    });
                });
        },

        forceFileDownload(response, title) {
            console.log(response, title)
            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', title)
            document.body.appendChild(link)
            link.click()
            },
        handleDownload(url, title) {
            console.log(url,title);
            axios({
            method: 'GET',
            url: '',
            responseType: 'arraybuffer',
            })
            .then((response) => {
            this.forceFileDownload(response, title)
            })
            .catch(() => console.log('error occured'))
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