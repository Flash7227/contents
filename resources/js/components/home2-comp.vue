<template>
    <div
        class="container"
        v-loading.fullscreen.lock="loading"
        element-loading-text="Уншиж байна..."
    >
    <h4>Блог</h4>
    <el-divider></el-divider>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
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
    },
    created() {
        // this.fetch();
    },
    // props:['permissions']
};
</script>
