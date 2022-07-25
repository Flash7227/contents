<template>
    <div class="container"
        v-loading.fullscreen.lock="loading"
        :element-loading-text="loadText"
        
    >
        <el-card
        
            >
            <!-- <div style="margin: 20px 0;">
                <el-radio-group v-model="selectedTag" @change="tagHandler">
                <el-radio-button value="">#Бүгд</el-radio-button>
                <el-radio-button  v-for="(value, index) in allTags" :key="index" :label="value" :value="value" >#{{ value }}</el-radio-button>
                </el-radio-group>
            </div> -->


            <el-form :inline="true" label-width="90px">
              <el-form-item label="Нэр">
                <div class="block">
                  <el-input v-model="search.name" placeholder="нэрээр хайх"></el-input>
                </div>
              </el-form-item>
              <el-form-item label="Төрөл">
                <div class="block">
                    <el-select v-model="search.type" placeholder="төрөл сонгох" clearable>
                        <el-option
                        v-for="fileType in fileTypes"
                        :key="fileType.value"
                        :label="fileType.label"
                        :value="fileType.value"
                        >
                        </el-option>
                    </el-select>
                </div>
              </el-form-item>
              <br>
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
                <el-button type="primary" plain icon="el-icon-search" @click="searchFunc">хайх</el-button>
              </el-form-item>
            </el-form>
            <el-divider></el-divider>
            <div class="text-right">
                <small class="grey">Нийт: {{ data.total }}</small>
            </div>   
            <el-table
            header-cell-class-name="my-header"
            style="text-align: center; width: 100%"
            class="card"
            stripe
            :data="data.data"
            border>
                <el-table-column
                    type="index"
                    :index="indexMethod"
                    align="center"
                    header-align="center"
                >
                </el-table-column>
                <el-table-column
                prop="type"
                label="Төрөл"
                width="120"
                align="center">
                <template slot-scope="scope">
                   
                    <div slot="reference" class="name-wrapper">
                        <span v-if="scope.row.type === 1" size="medium"><i class="el-icon-document mr-1"></i>Файл</span>
                        <span v-else-if="scope.row.type === 2" size="medium"><i class="el-icon-video-camera-solid blue mr-1"></i>Видео</span>
                        <span v-else-if="scope.row.type === 3" size="medium"><i class="el-icon-picture green mr-1"></i>Зураг</span>
                        <span v-else-if="scope.row.type === 4" size="medium"><i class="el-icon-reading yellow mr-1"></i>Нийтлэл</span>
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
                        #{{tag}}
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
                    width="100"
                    align="right"
                    header-align="center">
                    <template slot-scope="scope">
                        <el-button
                        v-if="scope.row.type === 3 || scope.row.type === 2"
                        size="small"
                        circle
                        :append-to-body="true"
                        @click="pickDetails(scope.row), dialogVisible = true
                        "><i class="el-icon-view"></i>
                        </el-button>
                        <el-button
                        size="small"
                        type="success"
                        circle
                        @click="handleDownload(scope.row.url, scope.row.download)"><i class="el-icon-download"></i>
                        </el-button>

                        
 
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
        <pagination
            :data="data"
            @pagination-change-page="fetch"
            :limit="3"
            align="center"
            class="my-2"
        ></pagination>

        <el-dialog
        :destroy-on-close="true"
        title="Tips"
        :visible.sync="dialogVisible"
        width="50%">
            <span
            v-if="types.type == 3"
            >
                <el-image 
                :src="types.download" 
                :preview-src-list="[types.download]"
                >
            </el-image>
            </span>
            <span
            v-if="types.type == 2"
            >
                <video
                    ref="video" 
                    class="video" 
                    width="100%" 
                    controls>
                    <source :src="types.download" type="video/mp4">
                </video>
            </span>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="dialogVisible = false">done</el-button>
            </span>
        </el-dialog>
    </div>
    
  
</template>

<script>
export default {
    data(){
        return{
            loading: false,
            loadText: "Уншиж байна...",
            dialogVisible: false,
            data: {},
            allTags: [],
            types: {
                file: '',
                created_at:'',
                download:'',
                id:'',
                name:'',
                size:'',
                tags:'',
                type:'',
                updated_at:'',
                url:'',
                user_id:'',
            },
            fileTypes: [
                {
                    value: 1,
                    label: "Файл",
                },
                {
                    value: 2,
                    label: "Видео",
                },
                {
                    value: 3,
                    label: "Постер",
                },
                {
                    value: 4,
                    label: "Нийтлэл",
                },
            ],
            selectedTag: '',

            search: {
                type:'',
                name:'',
                tag:'',
                date:''
            }
        }
    },
    methods:{
        fetch(page = 1) {
            axios.post("/user/shared/fetch?page=" + page)
                .then((response) => {
                    this.data = response.data[0];
                    this.collectTags();
                    if(response.data[0].total === 0){
                        
                        console.log('empty');
                         
                        this.$message({
                        showClose: true,
                        message: 'Хуваалцсан мэдээлэл олдсонгүй...',
                        type: 'error'
                        });
                    
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

        searchFunc(){
            axios.post("/user/shared/fetchSearch", { search: this.search})
                .then((response) => {
                    this.loading = false;
                    if(response.data){
                        console.log(response.data);
                        this.data = response.data[0];
                    }else{
                        console.log(response.data);
                        this.fetch();
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

        tagHandler(value) { 
            console.log(value);
            axios.post("/user/shared/fetchByTag", { selectedTag: value})
                .then((response) => {
                    if(response.data.total > 0){
                        console.log(response.data);
                        this.data = response.data;
                    }else if(response.data.total < 1){
                        console.log(response.data);
                        this.fetch();
                    }else {
                        console.log(response.data);
                        this.fetch();
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

        collectTags(){
            var tags = this.data.data;
            var array = [];
            tags.forEach(e => {
                JSON.parse(e.tags).forEach( a => {
                    array.push(a);
                })
            });

            function onlyUnique(value, index, self) {
                return self.indexOf(value) === index;
            }
            var unique = array.filter(onlyUnique); 
            this.allTags = unique;
        },

        filterTag(value, row) {
            console.log(value, row);
            return row.tags;   
        },
        filterHandler(value, row, column) {
            const property = column['property'];
            return row[property] === value;
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
            this.types.tags = JSON.parse(data.tags);
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

        indexMethod(index) {
            return (
                (this.data.current_page - 1) * this.data.per_page + index + 1
            );
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

.my-header{
    background: #3897e4 !important;
    color: white;
    text-transform: uppercase;
    font-size: 0.9em;
    line-height: auto;
  }

  .demo-input-label {
    display: inline-block;
    width: 130px;
  }

</style>