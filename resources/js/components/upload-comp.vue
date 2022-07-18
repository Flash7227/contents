<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        :element-loading-text="loadText"
    >
        <el-card>
            <p>Шинэ файл хуулах</p>
            <el-form
                ref="fileList"
                :model="fileList"
                label-width="120px"
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
                <el-form-item label="Файл" prop="upload">
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
                            size="mini"
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

                <!-- <el-form-item label="Тайлбар" prop="desc">
                <el-input v-model="fileList.desc"></el-input>
            </el-form-item> -->

                <el-form-item label="Tags" prop="tags">
                    <el-tag
                        v-for="(tag,index) in fileList.dynamicTags"
                        :key="index"
                        closable
                        :disable-transitions="false"
                        @close="handleClose(tag, 1)"
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
                        >#Нэмэх</el-button
                    >
                </el-form-item>
                <el-form-item label="Хуваалцах" prop="allowed">
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

                <el-form-item>
                    <el-form-item size="large">
                        <el-button
                            type="success"
                            icon="el-icon-upload2"
                            @click="submitUpload"
                            >Хуулах</el-button
                        >
                        <el-button @click="resetForm()">Cancel</el-button>
                    </el-form-item>
                </el-form-item>
            </el-form>
        </el-card>
        <el-card class="mt-2">
            <p>Таны хуулсан файлууд</p>
            <el-table :data="lists.data" border style="width: 100%" @row-click="openDetails">
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
                    align="center"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        {{ typeName(scope.row.type) }}
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
        </el-card>
        <pagination
            :data="lists"
            @pagination-change-page="fetch"
            :limit="3"
            align="center"
            class="my-2"
        ></pagination>
        <el-dialog
            title="Action"
            :visible.sync="dialogVisible"
            width="30%"
            :before-close="handleClose">
            <span>This is a message</span>
   
            <span slot="footer" class="dialog-footer">
                <div>
                    <el-button type="danger" icon="el-icon-delete">Устгах</el-button>
                    <el-button @click="downloadFile" type="success" icon="el-icon-download">Татах</el-button>
                </div>
            </span>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            loadText: "Уншиж байна...",
            dialogVisible: false,
            inputVisible: false,
            inputVisible2: false,
            inputValue: "",
            inputValue2: "",
            fileList: {
                dataType: "0",
                oldFilePath: "",
                name: "",
                desc: "",
                type: "1",
                dynamicTags: [],
                allowed: [],
                url:""
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
            ],
            emails: [],
            lists: {},
            rules: {
                name: [
                    { required: true, message: 'Заавал бөглөнө үү!', trigger: 'blur' }
                ],           
            }
        };
    },
    methods: {
        fetch() {
            this.loading = true;
            axios
                .post("/user/upload/fetch")
                .then((response) => {
                    this.loading = false;
                    this.lists = response.data;
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
                    this.loading = true;
                    this.$refs.upload.submit();
                }else{
                    this.$message({
                        message: 'Файл сонгогдоогүй байна!',
                        type: 'warning'
                    });
                }
            } else {
                console.log('error submit!!');
                return false;
            }
            });
            // console.log(this.fileList);
            // console.log(this.$refs.upload.uploadFiles);

        },
        downloadFile() {
            var url = this.fileList.url;
            // console.log(url);
            axios({
                url: '/storage/uploads/' + url, // File URL Goes Here
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');

                fileLink.href = fileURL;
                fileLink.setAttribute('download', url);
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
        handleProgress(event, file, fileList) {
            console.log(event);
            this.loadText = "Уншиж байна..." + Math.floor(event.percent) + "%";
        },
        handleSuccess() {
            this.loading = false;
            this.loadText = "Уншиж байна...";
            this.resetForm();
            this.$message({
                message: "Successful",
                type: "success",
                duration: 3000,
            });
            this.fetch();
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
            console.log(file);
            // console.log(fileList);
        },
        beforeAvatarUpload(file) {
            console.log(file.size);
            this.fileList.size = file.size;
            // const isJPG =
            //     file.type === "image/jpeg" || "image/png" || "image/gif";
            // const isLt2M = file.size / 1024 / 1024 < 2;
            // if (!isJPG) {
            //     this.$message.error("Avatar picture must be JPG format!");
            // }
            // if (!isLt2M) {
            //     this.$message.error("Avatar picture size can not exceed 2MB!");
            // }
            // return isJPG && isLt2M;
        },
        handleClose(tag, index) {
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
        resetForm() {
            // this.$refs[formName].resetFields();
            this.$refs.upload.clearFiles();
            this.fileList.name = "";
            this.fileList.desc = "";
            this.fileList.dynamicTags = [];
            this.fileList.allowed = [];
            this.fileList.size = "";
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
            var i = Math.floor( Math.log(size) / Math.log(1024) );
            return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        },
        handleClose(){
            this.dialogVisible = false;
        },
        openDetails(row, column, event){
            this.fileList.url = row.url;
            // console.log(row, column, event);
            this.dialogVisible = true;
        }
    },
    created() {
        this.fetch();
    },
    mounted() {},
    props: {
        csrf: {
            type: String,
        },
        states: {
            type: String,
        },
    },
};
</script>
<style scoped>
.el-form .el-select {
    width: 100%;
}
</style>
