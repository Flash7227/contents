<template>
    <div class="container my-4">
        <div class="text-left">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item v-for="(url, index) in urls" :key="index">{{url}}</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
    </div>
</template>
<script>
    export default {
        created(){
            // console.log(this.urls);
        },
        props:['urls']
    }
</script>
<style>
.el-breadcrumb__item{
    font-weight: 600;
    /* color:dodgerblue; */
    /* margin: 1em 0; */
}
.el-breadcrumb__inner{
    color:#1572A1;
}
.el-breadcrumb{
    margin: 1em 0;
    font-size: 1.2em;
}
</style>

  
