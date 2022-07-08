<template>
    <div>
        <Menu mode="horizontal" theme="primary" active-name="1">
            <!-- <MenuItem name="1">
                <Icon type="ios-paper" />
                内容管理
            </MenuItem> -->
            <MenuItem name="2">
                <Icon type="md-home" />
                Нүүр
            </MenuItem>
            <Submenu name="3">
                <template slot="title">
                    <Icon type="md-image" />
                    Контент
                </template>
                <MenuGroup title="Үндсэн">
                    <MenuItem name="3-1">Нийтлэл</MenuItem>
                    <MenuItem name="3-2">Бичлэг</MenuItem>
                    <MenuItem name="3-3">Постер</MenuItem>
                </MenuGroup>
                <MenuGroup title="Бусад">
                    <MenuItem name="3-4">MNB TV</MenuItem>
                    <MenuItem name="3-5">MNB RADIO</MenuItem>
                </MenuGroup>
            </Submenu>
            <MenuItem name="4" to="/test">
                <Icon type="md-help" />
                Бидний тухай
            </MenuItem>
        </Menu>
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
