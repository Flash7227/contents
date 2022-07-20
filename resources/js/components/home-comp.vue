<template>
    <div>
        <div class="row">
            <div class="container">
                <!-- <div class="col-lg-1 col-md-1 col-sm-1"></div>
                <div class="col-lg-18 col-md-18 col-sm-18"> -->
                    
                    <el-carousel indicator-position="outside">
                        <el-carousel-item v-for="item in 4" :key="item">
                        <h3>{{ item }}</h3>
                        </el-carousel-item>
                    </el-carousel>
                    <el-tabs type="border-card">
                        <el-tab-pane>
                            <span slot="label"><i class="el-icon-date"></i> Нийтлэл</span>
                            gfhgfgjf
                        </el-tab-pane>
                        <el-tab-pane label="Бичлэг">Бичлэг</el-tab-pane>
                        <el-tab-pane label="Постер">Постер</el-tab-pane>
                        <el-tab-pane label="Бусад">Бусад</el-tab-pane>
                    </el-tabs>
                       
                    
                <!-- </div>
                <div class="col-lg-1 col-md-1 col-sm12"></div> -->

            </div>
            
        </div>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        count: 0
      }
    },
    methods: {
      load () {
        this.count += 2
      }
    }
  }
</script>

<style>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    line-height: 300px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
</style>