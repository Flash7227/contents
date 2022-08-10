<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <el-card>
        <el-table
        :data="logs.data"
        style="width: 100%">
            <el-table-column
                type="index"
                :index="indexMethod"
                align="center"
                header-align="center"
            >
            </el-table-column>
            <el-table-column
                prop="user"
                label="Хэрэглэгч"
                >
                <template slot-scope="scope">
                    <span v-if="scope.row.user">{{scope.row.user.email}}</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="upload"
                label="Файл"
                >
                <template slot-scope="scope">
                    <span v-if="scope.row.upload">{{scope.row.upload.name}}</span>
                </template>
            </el-table-column>
            <el-table-column
                prop="action"
                label="Үйлдэл"
                width="180">
            </el-table-column>
            <el-table-column
                width="180"
                prop="created_at"
                label="Огноо">
                 <template slot-scope="scope">
                        {{dateformatter(scope.row.created_at, true)}}
                </template>
            </el-table-column>
        </el-table>
        <pagination
            :data="logs"
            @pagination-change-page="fetch"
            :limit="3"
            align="center"
            class="my-2"
        ></pagination>
    </el-card>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            logs:{},
            form:{

            }
        };
    },
    methods: {
        fetch() {
            this.loading = true;
            axios
                .post("/admin/logs/fetch", {form:this.form})
                .then((response) => {
                    this.loading = false;
                    this.logs = response.data;
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
        indexMethod(index) {
            return (
                (this.logs.current_page - 1) * this.logs.per_page + index + 1
            );
        },
        dateformatter(date, short) {
            if (short) {
                // console.log(short, '---');
                return moment(date).format("YYYY-MM-DD");
            } else {
                return moment(date).format("YYYY-MM-DD HH:mm");
            }
        },
    },
    created() {
        this.fetch();
    },
    props: {
        csrf: {
            type: String,
        }
    }
};
</script>
