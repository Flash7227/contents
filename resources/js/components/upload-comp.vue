<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        :element-loading-text="loadText"
    >
        <el-card v-if="persmissionCheck('upload')">
            <p class="text-right">Шинэ файл хуулах</p>
            <el-form
                ref="fileList"
                :model="fileList"
                label-width="140px"
                size="mini"
                :rules="rules"
            >
                <el-form-item label="Төрөл" prop="type">
                    <el-select v-model="fileList.type" placeholder="Сонгох">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Нийтлэл" prop="desc" v-if="fileList.type==4">
                    <!-- <ckeditor :editor="editor" v-model="fileList.desc" :config="editorConfig"></ckeditor> -->
                      <vue-editor
                        id="editor"
                        use-custom-image-handler
                        @image-added="handleImageAdded"
                        :editorOptions="editorSettings"
                        :editor-toolbar="editorSettings.customToolbar"
                        v-model="fileList.desc"/>
                </el-form-item>

                <el-form-item :label="fileList.type != 4 ? 'Файл' :'Нүүр зураг'" prop="upload">
                    <el-upload
                        ref="upload"
                        action="/user/upload"
                        list-type="text"
                        :file-list="attachments"
                        :data="fileList"
                        :auto-upload="false"
                        :limit="1"
                        :on-exceed="handleExceed"
                        :multiple="false"
                        :headers="{ 'X-CSRF-TOKEN': csrf }"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :before-upload="beforeAvatarUpload"
                        :on-progress="handleProgress"
                    >
                        <el-button
                            slot="trigger"
                            size="small"
                            icon="el-icon-document-add"
                            type="info"
                            plain
                            >File</el-button
                        >
                    </el-upload>
                </el-form-item>
                <el-form-item label="Нэр" prop="name">
                    <el-input v-model="fileList.name"></el-input>
                </el-form-item>

                <el-form-item label="#Tag" prop="tags">
                    <el-tag
                        v-for="(tag,index) in fileList.dynamicTags"
                        :key="index"
                        closable
                        :disable-transitions="false"
                        @close="tagClose(tag, 1)"
                    >
                        {{ tag }}
                    </el-tag>
                    <el-input
                        class="input-new-tag"
                        v-if="inputVisible"
                        v-model="inputValue"
                        ref="saveTagInput"
                        size="mini"
                        @keyup.enter.native="handleInputConfirm(1)"
                        @blur="handleInputConfirm(1)"
                    >
                    </el-input>
                    <el-button
                        v-else
                        class="button-new-tag"
                        size="small"
                        @click="showInput(1)"
                        >Нэмэх</el-button
                    >
                </el-form-item>
                <el-form-item label="Хуваалцах төрөл" prop="sharetype">
                    <el-select
                        v-model="fileList.sharetype"
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
                <el-form-item label="Хуваалцах" prop="allowed" v-if="fileList.sharetype == 'allowed'">
                    <el-select
                        v-model="fileList.allowed"
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
                <el-form-item label="Хуулах лимит">
                    <el-progress :text-inside="true" :stroke-width="15" :percentage="datapercent" :color="customColors" :format="customProgressFormat"></el-progress>
                </el-form-item>
                <el-form-item>
                    <el-button
                        plain
                        round
                        size="medium"
                        type="success"
                        icon="el-icon-upload2"
                        @click="submitUpload"
                        >Хуулах</el-button
                    >
                    <el-button size="medium" round @click="resetForm()">Cancel</el-button>
                </el-form-item>
            </el-form>
 
        </el-card>
        <el-card class="mt-2 mb-4">
            <p class="text-left">Таны хуулсан файлууд</p>
            <div class="text-right">
                <small class="grey">Нийт: {{lists.total}}ш</small>
            </div>
            <el-table :data="lists.data" border style="width: 100%" @row-click="openDetails" :header-cell-style="tableHeaderColor" :row-class-name="tableRowClassName">
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
                :data="lists"
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
                    <el-tag
                        v-for="(tag,index) in selected.dynamicTags"
                        :key="index"
                        closable
                        :disable-transitions="false"
                        @close="tagClose2(tag, 1)"
                    >
                        {{ tag }}
                    </el-tag>
                    <el-input
                        class="input-new-tag"
                        v-if="inputVisible"
                        v-model="inputValue"
                        ref="saveTagInput"
                        size="mini"
                        @keyup.enter.native="handleInputConfirm2(1)"
                        @blur="handleInputConfirm2(1)"
                    >
                    </el-input>
                    <el-button
                        v-else
                        class="button-new-tag"
                        size="small"
                        @click="showInput(1)"
                        >#Нэмэх</el-button
                    >
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
                        <el-button @click="modify(0)" type="danger" icon="el-icon-delete" class="float-left" circle></el-button>
                        <el-button v-if="selected.type != 4" @click="downloadFile" type="success" icon="el-icon-download" class="float-left" circle></el-button>
                        <el-button v-if="selected.type == 2 || selected.type == 3" @click="viewdata" icon="el-icon-view" circle class="float-left"></el-button>
                    </div>
                    <el-button @click="modify(1)" type="primary" icon="el-icon-edit" plain>Засах</el-button>
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
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import UploadAdapter from '../UploadAdapter';
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
            loadText: "Уншиж байна...",
            dialogVisible: false,
            viewVisible: false,
            inputVisible: false,
            inputVisible2: false,
            inputValue: "",
            inputValue2: "",
            fileList: {
                id: "",
                dataType: "0",
                oldFilePath: "",
                name: "",
                desc: "",
                type: "1",
                dynamicTags: [],
                sharetype:"all",
                allowed: [],
                url:"",
                size:""
            },
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
                sharetype:""
            },
            attachments: [],
            srcList: [],
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
            emails: [],
            lists: {},
            rules: {
                name: [
                    { required: true, message: 'Заавал бөглөнө үү!', trigger: 'blur' }
                ],           
            },
            // editor: ClassicEditor,
            editorConfig:{
                // plugins: [ Image, ImageResize],
                extraPlugins: [this.uploader],
                ui: {
                    // width: '500px',
                    height: '800px'
                },
                image: {
                    toolbar: [ 'toggleImageCaption', 'imageTextAlternative', 'ImageStyle', 'ImageResize']
                }
            },
            datapercent:0,
            dataused:"",
            customColors: [
                {color: '#a4edbc', percentage: 20},
                {color: '#b3baf5', percentage: 40},
                {color: '#6f7ad3', percentage: 60},
                {color: '#f2e399', percentage: 90},
                {color: '#f2c199', percentage: 100}
            ]
        };
    },
    methods: {
        fetch(page = 1) {
            this.loading = true;
            axios
                .post("/user/upload/fetch?page=" + page)
                .then((response) => {
                    this.loading = false;
                    this.lists = response.data[0];
                    this.dataused = response.data[1];
                    this.storageLimitCalculator();
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
        submitUpload() {
            this.$refs['fileList'].validate((valid) => {
                if (valid) {
                    if (this.$refs.upload.uploadFiles.length > 0) {
                            // this.loading = true;
                            this.$refs.upload.submit();
                        }else{
                            if(this.fileList.type == 4){
                                this.loading = true;
                                axios
                                    .post("/user/upload", {form: this.fileList})
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
                            }else{
                                this.$message({
                                    message: 'Файл сонгогдоогүй байна!',
                                    type: 'warning'
                                });
                            }
                        }
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        modify(type){
            this.$confirm('Та итгэлтэй байна уу?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                var temp = 'mod';
                if(type == 0){
                    temp = 'del';
                }
                axios
                .post("/user/upload/modify", {form: this.selected, type: temp})
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
        downloadFile() {
            var url = this.selected.url;
            var link = document.createElement("a");
            link.setAttribute('download', url);
            link.href = this.selected.download;
            document.body.appendChild(link);
            link.click();
            link.remove();
        },
        handleProgress(event, file, fileList) {
            // console.log(event);
            this.loadText = "Уншиж байна..." + Math.floor(event.percent) + "%";
        },
        handleSuccess(response) {
            console.log(response);
            this.loading = false;
            this.loadText = "Уншиж байна...";
            this.resetForm();
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
        addAttachment(file, fileList) {
            this.attachments.push(file);
        },
        beforeAvatarUpload(file) {
            this.fileList.size = file.size;
            var percent = (this.dataused + file.size) * 100 / parseInt(JSON.parse(this.user).storage_limit);
            // console.log(percent);
            if(percent > 100){
                this.$message.error(this.readableSize(file.size)+ "! Upload limit is exceeded, can not upload!");
                return false;
            }
            if(file.size > 16106127360){
                this.$message.error("MAX UPLOAD LIMIT AT A TIME IS 15GB!");
                return false;
            }
            if(this.fileList.type == 4){
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
            this.loading = true;
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
        tagClose(tag, index) {
            if (index == 1) {
                this.fileList.dynamicTags.splice(
                    this.fileList.dynamicTags.indexOf(tag),
                    1
                );
            } else {
                this.currentList.tags.splice(
                    this.currentList.tags.indexOf(tag),
                    1
                );
            }
        },
        tagClose2(tag, index) {
            if (index == 1) {
                this.selected.dynamicTags.splice(
                    this.selected.dynamicTags.indexOf(tag),
                    1
                );
            } else {
                this.currentList.tags.splice(
                    this.currentList.tags.indexOf(tag),
                    1
                );
            }
        },
        resetForm() {
            // this.$refs[formName].resetFields();
            this.$refs.upload.clearFiles();
            this.fileList.name = "";
            this.fileList.desc = "";
            this.fileList.dynamicTags = [];
            this.fileList.allowed = [];
            this.fileList.size = "";
            this.fileList.id = "";
            this.fileList.download = "";
            this.fileList.sharetype = "all";
        },
        showInput(index) {
            if (index == 1) {
                this.inputVisible = true;
                this.$nextTick((_) => {
                    this.$refs.saveTagInput.$refs.input.focus();
                });
            } else {
                this.inputVisible2 = true;
                this.$nextTick((_) => {
                    this.$refs.saveTagInput2.$refs.input.focus();
                });
            }
        },
        handleInputConfirm(index) {
            if (index == 1) {
                let inputValue = this.inputValue;
                if (inputValue) {
                    this.fileList.dynamicTags.push(inputValue);
                }
                this.inputVisible = false;
                this.inputValue = "";
            } else {
                let inputValue2 = this.inputValue2;
                if (inputValue2) {
                    this.currentList.tags.push(inputValue2);
                }
                this.inputVisible2 = false;
                this.inputValue2 = "";
            }
        },
        handleInputConfirm2(index) {
            if (index == 1) {
                let inputValue = this.inputValue;
                if (inputValue) {
                    this.selected.dynamicTags.push(inputValue);
                }
                this.inputVisible = false;
                this.inputValue = "";
            } else {
                let inputValue2 = this.inputValue2;
                if (inputValue2) {
                    this.currentList.tags.push(inputValue2);
                }
                this.inputVisible2 = false;
                this.inputValue2 = "";
            }
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
                (this.lists.current_page - 1) * this.lists.per_page + index + 1
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
        handleClose(){
            this.dialogVisible = false;         
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
            this.dialogVisible = true;
        },
        uploader(editor)
        {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader, csrf ) => {
                return new UploadAdapter( loader, this.csrf);
            };
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
        tableHeaderColor({ row, column, rowIndex, columnIndex }) {
            if (rowIndex === 0) {
                return 'background-color:#84A4C1; color:white; text-transform:uppercase; letter-spacing:1px; font-weight:700; text-align:center; font-size:0.8em; padding: 1em 0;' 
            }
        },
        customProgressFormat(percent){
            var percent = this.dataused * 100 / parseInt(JSON.parse(this.user).storage_limit);
            if(percent > 100){
                return 'Over the limit! ' + this.readableSize(this.dataused) + '/' + this.readableSize(parseInt(JSON.parse(this.user).storage_limit));
            }else{
                return this.readableSize(this.dataused) + '/' + this.readableSize(parseInt(JSON.parse(this.user).storage_limit));
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
        persmissionCheck(type){
            // console.log(JSON.parse(this.user).permissions);
            if(type == 'upload'){
                if(JSON.parse(this.user).permissions.includes('upload')){
                    return true;
                }
            }else if(type=='public'){
                if(!JSON.parse(this.user).permissions.includes('public')){
                    var temp1 = this.sharetypes;
                    var temp2 = this.sharetypes.splice(0, 1);
                    this.sharetypes = temp1;
                }
            }
        },
        storageLimitCalculator(){
            var percent = this.dataused * 100 / parseInt(JSON.parse(this.user).storage_limit);
            if(percent > 100){
                this.datapercent = 100;
            }else{
                this.datapercent = percent;
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
        }
    },
    created() {
        this.fetch();
       
    },
    mounted() {
        this.persmissionCheck('public');
    },
    props: {
        csrf: {
            type: String,
        },
        states: {
            type: String,
        },
        user:{
            type:String
        }
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
