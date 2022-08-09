<template>
    <div
        class="container-fluid"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <el-card class="mt-2 mb-4">
            <p class="text-left">Хуулсан файлын жагсаалт</p>
            <el-form :inline="true">
                <el-form-item label="Төрөл" prop="type">
                    <el-select v-model="form.type" placeholder="Сонгох" clearable>
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                  <el-form-item label="Хэрэглэгчийн имайл" prop="allowed">
                    <el-select
                        v-model="form.email"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Имайл"
                        :remote-method="remoteMethod"
                        :loading="loading"
                        allow-create
                        default-first-option
                        clearable
                    >
                        <el-option
                            v-for="(item, index) in emails"
                            :key="index"
                            :label="item"
                            :value="item"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button icon="el-icon-search" type="primary" @click="fetch">Хайх</el-button>
                </el-form-item>
            </el-form>
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
                        <i v-if="scope.row.type == 1" class="el-icon-document indicator-icon"></i>
                        <i v-else-if="scope.row.type == 2" class="el-icon-video-camera-solid blue indicator-icon"></i>
                        <i v-else-if="scope.row.type == 3" class="el-icon-picture green indicator-icon"></i>
                        <i v-else-if="scope.row.type == 4" class="el-icon-reading yellow indicator-icon"></i>
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
                    width="150"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        <el-tag
                            type="info"
                            class="mr-1 mb-1"
                            v-for="(tag, index) in JSON.parse(scope.row.tags)"
                            :key="index"
                            >{{ tagFinder(tag) }}</el-tag
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
                <!----------------------------- view count start -->
                <el-table-column
                    prop="counter"
                    label="Үзсэн/татагдсан тоо"
                    align="center"
                    header-align="center"
                    width="180"
                >
                    <template slot-scope="scope"
                    
                    ><el-tag type="info" v-if="scope.row.counter[0]">
                     <i class="el-icon-view"></i>
                        {{scope.row.counter[0].view}}
                    </el-tag>
                        <el-tag type="info" v-if="scope.row.counter[0]">
                    <i class="el-icon-download"></i>
                        {{scope.row.counter[0].download}}
                         </el-tag>
                         <el-tag type="info" v-if="!scope.row.counter[0]">
                     <i class="el-icon-view"></i>
                        0
                    </el-tag>
                         <el-tag type="info" v-if="!scope.row.counter[0]">
                    <i class="el-icon-download"></i>
                        0
                         </el-tag>
                    </template>
                    
                </el-table-column>
                <!----------------------------- view count end -->
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
            <pagination
                :data="uploads"
                @pagination-change-page="fetch"
                :limit="3"
                align="center"
                class="my-2"
            ></pagination>
        </el-card>
        <el-dialog
            title="Дэлгэрэнгүй"
            :visible.sync="dialogVisible"
            width="90%"
            :before-close="handleClose">
            <el-form                
                ref="invisModify"
                :model="selected"
                label-width="160px"
                size="mini"
                :rules="rules">

                <el-form-item label="Нийтлэл" prop="desc" v-if="selected.type==4">
                    <!-- <ckeditor :editor="editor" v-model="selected.desc" :config="editorConfig"></ckeditor> -->
                        <vue-editor
                        id="editor2"
                        use-custom-image-handler
                        @image-added="handleImageAdded"
                        :editor-toolbar="editorSettings.customToolbar"
                        v-model="selected.desc"/>
                </el-form-item>
                <el-form-item label="Нэр" prop="name">
                    <el-input v-model="selected.name"></el-input>
                </el-form-item>
                <el-form-item label="Cover зураг" prop="upload" v-if="selected.type == 4">
                    <el-upload
                        class="avatar-uploader"
                        action="/user/upload/modify/cover"
                        :show-file-list="false"
                        :on-success="handleSuccess"
                        :data="selected"
                        accept="image/jpeg,image/gif,image/png"
                        :on-error="handleError"
                        :headers="{ 'X-CSRF-TOKEN': csrf }"
                        :before-upload="beforeCoverUpload">
                        <img v-if="selected.url != 'noimage123.png'" :src="selected.download" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                    <small class="grey">Солиход шууд өөрчлөгдөнө!</small>
                </el-form-item>
                <el-form-item label="Tags" prop="tags">
                       <el-select v-model="selected.dynamicTags" placeholder="Сонгох"
                        multiple
                        filterable>
                        <el-option
                        v-for="(tag,index) in JSON.parse(tags)"
                        :key="index"
                        :label="tag.name"
                        :value="tag.id"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Хуваалцах төрөл" prop="sharetype">
                    <el-select
                        v-model="selected.sharetype"
                    >
                        <el-option
                            v-for="(item, index) in sharetypes"
                            :key="index"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item v-if="selected.sharetype == 'allowed'" label="Хуваалцах жагсаалт" prop="allowed">
                    <el-select
                        v-model="selected.allowed"
                        multiple
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Имайл"
                        :remote-method="remoteMethod"
                        :loading="loading"
                        allow-create
                        default-first-option
                    >
                        <el-option
                            v-for="(item, index) in emails"
                            :key="index"
                            :label="item"
                            :value="item"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
   
            <span slot="footer" class="dialog-footer">
                    <div>
                        <el-button @click="modify('delete')" type="danger" icon="el-icon-delete" class="float-left" circle></el-button>
                        <el-button v-if="selected.type != 4" @click="downloadFile" type="success" icon="el-icon-download" class="float-left" circle></el-button>
                        <el-button v-if="selected.type == 2 || selected.type == 3" @click="viewdata" icon="el-icon-view" circle class="float-left"></el-button>
                    </div>
                    <el-button @click="modify('edit')" type="primary" icon="el-icon-edit" plain>Засах</el-button>
            </span>
    </el-dialog>
    <el-dialog
            title="Үзэх"
            :visible.sync="viewVisible"
            width="90%"
            append-to-body
            :before-close="handleCloseView">

            <div v-if="selected.type == 2" class="text-center">
                <video width="90%" height="auto" controls ref="video" >
                    <source :src="selected.download" type="video/mp4" ref="source1"/>
                    <source :src="selected.download" :type="getExt()" ref="source2"/>
                    Your browser does not support the video tag.
                </video>
            </div>
            <div v-else-if="selected.type == 3" class="text-center demo-image__preview">
                <el-image 
                    style="width: 90%; height: auto"
                    :src="selected.download" 
                    :preview-src-list="[selected.download]">
                </el-image>
            </div>

    </el-dialog>
    </div>
</template>

<script>
import { VueEditor, Quill } from 'vue2-editor'
import ImageResize from 'quill-image-resize-vue'
Quill.register('modules/imageResize', ImageResize)
const quillTable = require('vue-quill-table');
 
Quill.register(quillTable.TableCell);
Quill.register(quillTable.TableRow);
Quill.register(quillTable.Table);
Quill.register(quillTable.Contain);
Quill.register('modules/table', quillTable.TableModule);
const maxRows = 10;
const maxCols = 5;
const tableOptions = [];
for (let r = 1; r <= maxRows; r++) {
    for (let c = 1; c <= maxCols; c++) {
        tableOptions.push('newtable_' + r + '_' + c);
    }
}
export default {
    data() {
        return {
            editorSettings: {
                modules: {
                    imageResize: {},
                    table: {}
                },
                customToolbar: [
                    [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                    ["bold", "italic", "underline", "strike"], // toggled buttons
                    [
                        { align: "" },
                        { align: "center" },
                        { align: "right" },
                        { align: "justify" }
                    ],
                    ["blockquote", "code-block"],
                    [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
                    [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
                    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
                    ["link", "image", "video"],
                    ["clean"], // remove formatting button
                     [{table: tableOptions}, {table: 'append-row'}, {table: 'append-col'}],
                ]
            },
            loading: false,
            dialogVisible: false,
            viewVisible: false,
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
            rules: {
                name: [
                    { required: true, message: 'Заавал бөглөнө үү!', trigger: 'blur' }
                ],           
            },
            form:{
                email:"",
                type:""
            },
            emails:[]
        };
    },
    methods: {
        fetch(page = 1) {
            this.loading = true;
            axios
                .post("/admin/uploads/fetch?page=" + page, {form:this.form})
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
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("upload", file);
            axios({
                url: "/vue2/upload",
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': this.csrf
                },
                data: formData
            }).then(result => {
                const url = result.data.url; // Get url from response
                Editor.insertEmbed(cursorLocation, "image", url);
                resetUploader();
            }).catch(err => {
                console.log(err);
            });
        },
        handleCloseView(){
            if(this.selected.type == 2){
                var video = this.$refs.video;
                video.play();
                video.pause();
                // video.currentTime = 0;
            }
            this.viewVisible = false;         
        },
        getExt(){
            var url = this.selected.url.split('.');
            return 'video/'+url[url.length - 1];
        },
        handleSuccess(response) {
            console.log(response);
            this.loading = false;
            this.loadText = "Уншиж байна...";
            // this.resetForm();
            if(response == 'success'){
                this.$message({
                    message: "Successful",
                    type: "success",
                    duration: 3000,
                });
                this.fetch();
            }else{
                this.$notify.error({
                    title: "Error",
                    message: response
                });
            }
        },
        async viewdata() {
            this.viewVisible = true;
            if(this.selected.type == 2){
                this.loading = true;
                const result = await this.viewAfter();
            }
        },
        viewAfter() {
            return new Promise(resolve => {
                setTimeout(() => {
                this.loading = false;
                    var video = this.$refs.video;
                    var source1 = this.$refs.source1;
                    var source2 = this.$refs.source2;
                    source1.setAttribute('src', this.selected.download);
                    source2.setAttribute('src', this.selected.download);
                    video.load();
                }, 1000);
            });
        },
        handleError() {
            this.loading = false;
            this.loadText = "Уншиж байна...";
            this.$message({
                message: "Error!",
                type: "error",
                duration: 3000,
            });
            // this.fetch();
        },
        handleExceed(files, fileList) {
            this.$message({
                message: "Please upload one at the time!",
                type: "warning",
                duration: 4000,
            });
        },
        beforeCoverUpload(file){
            this.selected.size = file.size;
            if(this.selected.type == 4){
                const isJPG =
                file.type === "image/jpeg" || "image/png" || "image/gif";
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isJPG) {
                    this.$message.error("Avatar picture must be JPG format!");
                    return false;
                }
                if (!isLt2M) {
                    this.$message.error("Avatar picture size can not exceed 2MB!");
                    return false;
                }
                return isJPG && isLt2M;
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
                return 'background-color:#84A4C1; color:white; text-transform:uppercase; letter-spacing:1px; font-weight:700; text-align:center; font-size:0.8em; padding: 1em 0;' 
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
        downloadFile() {
            var url = this.selected.url;
            var link = document.createElement("a");
            link.setAttribute('download', url);
            link.href = this.selected.download;
            document.body.appendChild(link);
            link.click();
            link.remove();
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
        remoteMethod(query) {
            if (query !== "") {
                // this.loading = true;
                setTimeout(() => {
                    // this.loading = false;
                    this.emails = JSON.parse(this.states).filter((item) => {
                        return (
                            item.toLowerCase().indexOf(query.toLowerCase()) > -1
                        );
                    });
                }, 100);
            } else {
                this.emails = [];
            }
        },
        tagFinder(id){
            // console.log(id);
            if(id){
                var filtered = (JSON.parse(this.tags)).filter(
                    (tag) => tag.id == id
                );
                // console.log(filtered);
                if (filtered[0]) {
                    return filtered[0].name;
                } else {
                    return "TAG NOT FOUND!";
                }
            }
            
        }
    },
    created() {
        this.fetch();
    },
    props: {
        csrf: {
            type: String,
        },
        states: {
            type: String,
        },
        tags: {
            type: String,
        },
    },
};
</script>
<style scoped>
    .el-form .el-select {
        width: 100%;
    }
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
    .el-table .file-row{
        background: #409EFF;
    }

</style>