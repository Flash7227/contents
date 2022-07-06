<template>
    <div class="container">
        <Button>Default</Button>
        <Button type="primary">Primary</Button>
        <Button type="dashed">Dashed</Button>
        <Button type="text">Text</Button>
        <br><br>
        <Button type="info">Info</Button>
        <Button type="success">Success</Button>
        <Button type="warning">Warning</Button>
        <Button type="error">Error</Button>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                loading: false,
            }
        },
        methods:{
            spinStart(){
                this.$Spin.show({
                    render: (h) => {
                        return h('div', [
                            h('Icon', {
                                'class': 'demo-spin-icon-load',
                                props: {
                                    type: 'ios-loading',
                                    size: 38
                                }
                            }),
                            h('div', 'Loading')
                        ])
                    }
                })
            },
            fetch(){
                this.spinStart();
                axios.get("/test")
                .then(response => {
                    this.$Spin.hide();
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error.response);
                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                });
            },

        },
        created(){
            // this.fetch();
        }
    }
</script>
