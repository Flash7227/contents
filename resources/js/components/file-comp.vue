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
                <el-row>
                    <!-- file -->
                    <el-col>
                        <el-table :data="filesData.data" border style="width: 100%">
                            <el-table-column
                                type="index"
                                :index="indexMethod"
                                align="center"
                                header-align="center"
                            >
                            </el-table-column>
                            <!-- <el-table-column
                                prop="type"
                                label="Төрөл"
                                width="110"
                                align="center"
                                header-align="center"
                            >
                                <template slot-scope="scope">
                                    {{ typeName(scope.row.type) }}
                                </template>
                            </el-table-column> -->
                            <el-table-column
                                prop="name"
                                label="Нэр"
                                align="center"
                                header-align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="tags"
                                label="Tags"
                                align="center"
                                header-align="center"
                            >
                                <template slot-scope="scope">
                                    <el-tag
                                        type="info"
                                        class="mr-1 mb-1"
                                        v-for="(tag, index) in JSON.parse(scope.row.tags)"
                                        :key="index"
                                        >{{ tag }}</el-tag
                                    >
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="size"
                                label="Хуваалцсан"
                                align="center"
                                width="100"
                                header-align="center"
                            >
                                <template slot-scope="scope">
                                    <el-popover
                                        placement="right"
                                        title="Хуваалцсан жагсаалт"
                                        width="200"
                                        trigger="hover"
                                        >
                                        <table class="table text-center">
                                            <tr v-for="(dat, index) in JSON.parse(scope.row.allowed)" :key="index">
                                                <td class="grey">{{index + 1}}</td>
                                                <td>
                                                    {{dat}}
                                                </td>
                                            </tr>
                                        </table>
                                        <el-button size="small" slot="reference">{{JSON.parse(scope.row.allowed).length}} <i class="el-icon-user"></i></el-button>
                                    </el-popover>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="size"
                                label="Хэмжээ"
                                align="center"
                                width="100"
                                header-align="center"
                            >
                                <template slot-scope="scope">
                                    {{readableSize(scope.row.size)}}
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="created_at"
                                label="Огноо"
                                align="center"
                                header-align="center"
                                width="160"
                            >
                                <template slot-scope="scope">
                                    <i class="el-icon-time"></i>
                                    {{ dateformatter(scope.row.created_at) }}
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-col>
                    <!-- <pagination
                        :data="filesData"
                        @pagination-change-page="filesData"
                        :limit="3"
                        align="center"
                        class="my-2"
                    ></pagination> -->
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
        filesData:[],
        activeIndex: '',
        activeName: '',
        
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
            (this.filesData.current_page - 1) * this.filesData.per_page + index + 1
        );
    },          
    typeName(type) {
        var filtered = this.options.filter(
            (option) => option.value == type
        );
        if (filtered) {
            return filtered[0].label;
        } else {
            return "Unknown type";
        }
    },
    readableSize(size){
        if(size != 0){
            var i = Math.floor( Math.log(size) / Math.log(1024) );
            return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        }        
    },
      
      getfilesData(){
        axios
        .get("/home/getupload")
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
      }
    },
    created() {
        this.getfilesData();
    },
 }
</script>