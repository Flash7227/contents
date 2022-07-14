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
                <el-form-item label="Файл">
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
                        :key="tag"
                        v-for="tag in fileList.dynamicTags"
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
                            v-for="item in emails"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
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
                        <el-button @click="resetForm('fileList')"
                            >Cancel</el-button
                        >
                    </el-form-item>
                </el-form-item>
            </el-form>
        </el-card>
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
            form: {},
            fileList: {
                dataType: "0",
                oldFilePath: "",
                name: "",
                desc: "",
                type: "1",
                dynamicTags: [],
                allowed: [],
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
            list: [],
            states: [
                "Alabama",
                "Alaska",
                "Arizona",
                "Arkansas",
                "California",
                "Colorado",
                "Connecticut",
                "Delaware",
                "Florida",
                "Georgia",
                "Hawaii",
                "Idaho",
                "Illinois",
                "Indiana",
                "Iowa",
                "Kansas",
                "Kentucky",
                "Louisiana",
                "Maine",
                "Maryland",
                "Massachusetts",
                "Michigan",
                "Minnesota",
                "Mississippi",
                "Missouri",
                "Montana",
                "Nebraska",
                "Nevada",
                "New Hampshire",
                "New Jersey",
                "New Mexico",
                "New York",
                "North Carolina",
                "North Dakota",
                "Ohio",
                "Oklahoma",
                "Oregon",
                "Pennsylvania",
                "Rhode Island",
                "South Carolina",
                "South Dakota",
                "Tennessee",
                "Texas",
                "Utah",
                "Vermont",
                "Virginia",
                "Washington",
                "West Virginia",
                "Wisconsin",
                "Wyoming",
            ],
        };
    },
    methods: {
        fetch() {
            this.loading = true;
            axios
                .get("/test")
                .then((response) => {
                    this.loading = false;
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
            // console.log(this.fileList);
            // console.log(this.$refs.upload.uploadFiles);
            if (this.$refs.upload.uploadFiles.length > 0) {
                this.loading = true;
                this.$refs.upload.submit();
            }
        },
        handleProgress(event, file, fileList) {
            console.log(event);
            this.loadText = "Уншиж байна..." + Math.floor(event.percent) + "%";
        },
        handleSuccess() {
            this.loading = false;
            this.loadText = "Уншиж байна...";
            this.resetForm("fileList");
            this.$message({
                message: "Successful",
                type: "success",
                duration: 3000,
            });
            this.$refs.upload.clearFiles();
            // this.fetch();
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
        resetForm(formName) {
            // this.$refs[formName].resetFields();
            this.fileList.name = "";
            this.fileList.desc = "";
            this.fileList.dynamicTags = [];
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
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.emails = this.list.filter((item) => {
                        return (
                            item.label
                                .toLowerCase()
                                .indexOf(query.toLowerCase()) > -1
                        );
                    });
                }, 200);
            } else {
                this.emails = [];
            }
        },
    },
    created() {
        // this.fetch();
    },
    mounted() {
        this.list = this.states.map((item) => {
            return { value: `value:${item}`, label: `label:${item}` };
        });
    },
    props: {
        csrf: {
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
