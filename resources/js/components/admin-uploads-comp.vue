<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <el-card class="mt-2">
            <p class="text-left">Хэрэглэгчидийн хуулсан файлууд</p>
            <div class="text-right">
                <small class="grey">Нийт: {{uploads.total}}ш / Хэмжээ: {{readableSize(dataused)}}</small>
            </div>
            <el-table :data="uploads.data" border style="width: 100%" @row-click="openDetails" :header-cell-style="tableHeaderColor" :row-class-name="tableRowClassName">
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
                    width="110"
                    align="left"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        <i v-if="scope.row.type == 1" class="el-icon-document"></i>
                        <i v-else-if="scope.row.type == 2" class="el-icon-video-camera-solid blue"></i>
                        <i v-else-if="scope.row.type == 3" class="el-icon-picture green"></i>
                        <i v-else-if="scope.row.type == 4" class="el-icon-reading yellow"></i>
                        <span class="ml-1">{{ typeName(scope.row.type) }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="Нэр"
                    align="center"
                    header-align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="tags"
                    label="#tag"
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
                    width="160"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        <el-popover

                            placement="right"
                            title="Сонгож хуваалцсан жагсаалт"
                            width="300"
                            trigger="hover"
                            >
                            <table class="table text-center" v-if="scope.row.sharetype == 'allowed'">
                                <tr v-for="(dat, index) in JSON.parse(scope.row.allowed)" :key="index">
                                    <td class="grey">{{index + 1}}</td>
                                    <td>
                                        {{dat}}
                                    </td>
                                </tr>
                            </table>
                            <p v-else-if="scope.row.sharetype == 'public'">Бүх хүмүүст</p>
                            <p v-else-if="scope.row.sharetype == 'onlyme'">Зөвхөн өөртөө</p>
                            <p v-else-if="scope.row.sharetype == 'all'">Бүртгэлтэй бүх хүнд</p>
                            <el-button size="small" slot="reference">
                                <span v-if="scope.row.sharetype == 'public'">Бүх хүнд</span>
                                <span v-if="scope.row.sharetype == 'all'">Бүртгэлтэй бүгдэд</span>
                                <span v-if="scope.row.sharetype == 'onlyme'">Зөвхөн өөртөө</span>
                                <span v-if="scope.row.sharetype == 'allowed'">{{JSON.parse(scope.row.allowed).length}} <i class="el-icon-user"></i></span>
                            </el-button>
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
                    prop="size"
                    label="Эзэн"
                    align="center"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        {{scope.row.user.email}}
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
        </el-card>
        <pagination
            :data="uploads"
            @pagination-change-page="fetch"
            :limit="3"
            align="center"
            class="my-2"
        ></pagination>

     <el-dialog
            title="Дэлгэрэнгүй"
            :visible.sync="dialogVisible"
            width="90%"
            :before-close="handleClose">
            <table class="table table-bordered">
                <tr>
                    <th>Төрөл</th>
                    <th>Файлын нэр</th>
                    <th>Файлын хэмжээ</th>
                    <th>Огноо</th>
                    <th>Хэрэглэгчийн ID</th>
                    <th>Хэрэглэгчийн нэр</th>
                    <th>Хэрэглэгчийн email</th>
                    <th>Хэрэглэгчийн тайлбар</th>
                </tr>
                <tr>
                    <td>{{ typeName(selected.type) }}</td>
                    <td>{{selected.name}}</td>
                    <td> {{readableSize(selected.size)}}</td>
                    <td>{{ dateformatter(selected.created_at) }}</td>
                    <td>{{selected.user.id}}</td>
                    <td>{{selected.user.name}}</td>
                    <td>{{selected.user.email}}</td>
                    <td>{{selected.user.desc}}</td>
                </tr>
            </table>
            <div class="text-right">
                <el-button icon="el-icon-delete" type="danger" @click="modify('del')">Устгах</el-button>
            </div>
     </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            dialogVisible: false,
            uploads:{},
                        options: [
                {
                    value: "1",
                    label: "Файл",
                },
                {
                    value: "2",
                    label: "Бичлэг",
                },
                {
                    value: "3",
                    label: "Постер",
                },
                {
                    value: "4",
                    label: "Нийтлэл",
                },
            ],
            sharetypes: [
                {
                    value: "public",
                    label: "Бүх хүнд",
                },
                {
                    value: "all",
                    label: "Бүртгэлтэй бүгдэд",
                },
                {
                    value: "onlyme",
                    label: "Зөвхөн өөртөө",
                },
                {
                    value: "allowed",
                    label: "Сонгож хуваалцах",
                }
            ],
            dataused: 0,
            selected:{
                id:"",
                name: "",
                desc: "",
                type: "1",
                dynamicTags: [],
                allowed: [],
                url:"",
                size:"",
                download: "",
                sharetype:"",
                user:{}
            },
        };
    },
    methods: {
        fetch(page = 1) {
            this.loading = true;
            axios
                .post("/admin/uploads/fetch?page=" + page)
                .then((response) => {
                    this.loading = false;
                    this.uploads = response.data[0];
                    this.dataused = response.data[1];
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
        modify(type){
            this.$confirm('Та итгэлтэй байна уу?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                axios
                .post("/admin/uploads/modify", {form: this.selected, type: type})
                .then((response) => {
                    this.loading = false;
                    if(response.data == 'success'){
                        this.$message({
                            type: 'success',
                            message: 'Амжилттай!'
                        });
                        this.handleClose();
                        this.fetch();
                    }else{
                        this.$notify.error({
                            title: "Error",
                            message: response.data
                        });
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

            }).catch(() => {
                // this.$message({
                //     type: 'info',
                //     message: 'Цуцлагдлаа'
                // });          
            });
            
        },
        readableSize(size){
            if(size != 0){
                var i = Math.floor( Math.log(size) / Math.log(1024) );
                return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
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
        tableHeaderColor({ row, column, rowIndex, columnIndex }) {
            if (rowIndex === 0) {
                return 'background-color:grey; color:white; text-transform:uppercase; letter-spacing:1px; font-weight:700; text-align:center; font-size:0.8em; padding: 1em 0;' 
            }
        },
        tableRowClassName({row, rowIndex}) {
            // console.log(row);
            if (row.type === 1) {
                return 'file-row';
            } else if (row.type === 2) {
                return 'video-row';
            } else if (row.type === 3) {
                return 'poster-row';
            } else if (row.type === 4) {
                return 'post-row';
            }
            return '';
        },
        indexMethod(index) {
            return (
                (this.uploads.current_page - 1) * this.uploads.per_page + index + 1
            );
        },
        openDetails(row, column, event){
            this.selected.type = row.type;
            this.selected.url = row.url;
            this.selected.id = row.id;
            this.selected.desc = row.desc;  
            this.selected.allowed = JSON.parse(row.allowed);
            this.selected.name = row.name;
            this.selected.dynamicTags = JSON.parse(row.tags);
            this.selected.download = row.download;
            this.selected.sharetype = row.sharetype;
            this.selected.user = row.user;
            this.selected.size = row.size;
            this.dialogVisible = true;
        },
        resetForm() {
            this.selected.id = "";
            this.selected.type = "";
            this.selected.url = "";
            this.selected.name = "";
            this.selected.desc = "";
            this.selected.dynamicTags = [];
            this.selected.allowed = [];
            this.selected.size = "";
            this.selected.id = "";
            this.selected.download = "";
            this.selected.sharetype = "all";

        },
        handleClose(){
            this.dialogVisible = false;         
        },
    },
    created() {
        this.fetch();
    },
    // props:['permissions']
};
</script>
