<template>
  <div class="container">
    <el-container>
      <el-header>
        <el-menu :default-active="activeIndex"  mode="horizontal" @select="handleSelect">
          <el-menu-item index="1"><el-button round>НИЙТЛЭЛ</el-button></el-menu-item>
          <el-menu-item index="2"><el-button round>ПОСТЕР</el-button></el-menu-item>
          <el-menu-item index="3"><el-button round>БИЧЛЭГ</el-button></el-menu-item>
          <el-menu-item index="4"><el-button round>ФАЙЛ</el-button></el-menu-item>
        </el-menu>

        <!-- <el-tabs v-model="activeName" @tab-click="handleClick">
          <el-tab-pane label="НИЙТЛЭЛ" name="first">vhfg</el-tab-pane>
          <el-tab-pane label="ПОСТЕР" name="second">Config</el-tab-pane>
          <el-tab-pane label="БИЧЛЭГ" name="third">Role</el-tab-pane>
          <el-tab-pane label="ФАЙЛ" name="fourth">Task</el-tab-pane>
        </el-tabs> -->
      </el-header>
      <el-main :data="uploadData.data">
        <el-carousel indicator-position="outside">
            <el-carousel-item v-for="item in 4" :key="item">
            <h3>{{ item }}</h3>
            </el-carousel-item>
        </el-carousel>
        <el-row>
          <!-- Nittlel -->
          <el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="index > 0 ? 3 : 0">
            <el-card :data="uploadData.data" :body-style="{ padding: '0px' }" >
              <div class="demo-image__preview">
                <el-image 
                  style="width: 300px; height:300px" 
                  :src="url"
                  :preview-src-list="srcList">
                </el-image>
              </div>

              <div style="padding: 10px;">
                <span>
                  <!-- <template slot-scope="scope">
                      {{scope.row.name}}
                  </template> -->
                </span>
                <div class="bottom clearfix">
                  <time class="time">{{ currentDate }}</time>
                  <el-button type="text" class="button">Нийтлэл</el-button>
                </div>
              </div>
            </el-card>
          </el-col>
          <!-- poster -->
          <el-col :span="18" style="padding: 10px;">
            <el-card >
              <div :data="uploadData.data">
                <el-divider content-position="left">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-tickets">ПОСТЕР</el-button>
                  </el-badge>
                </el-divider> 
                <span> 
                  <template slot-scope="scope">
                    {{scope.row.name}}
                  </template>
                </span>
                <span>What you are you do not see, what you see is your shadow.</span>
              </div>
            </el-card>
          </el-col>
          <!-- file -->
          <el-col :span="6" style="padding: 10px;" >
            <el-card >
              <div>
                <el-divider content-position="right">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-files">ФАЙЛ</el-button>
                  </el-badge>
                </el-divider>
                <span>I cannot choose the best. The best chooses me.</span>
                <el-divider><i class="el-icon-star-on"></i></el-divider>
                <span>My wishes are fools, they shout across thy song, my Master. Let me but listen.</span>
                <el-divider content-position="right">Rabindranath Tagore</el-divider>
              </div>
            </el-card>
          </el-col>
          <!-- video -->
          <el-col :span="24" style="padding: 10px;" >
            <el-card >
              <div>
                <el-divider content-position="right">
                  <el-badge :value="12" class="item">
                    <el-button type="default" icon="el-icon-files">БИЧЛЭГ</el-button>
                  </el-badge>
                </el-divider>
                <video width="400" controls>
                  <source src="mov_bbb.mp4" type="video/mp4">
                  <source src="mov_bbb.ogg" type="video/ogg">
                  Your browser does not support HTML video.
                </video>
              </div>
            </el-card>
          </el-col>
        </el-row>
      </el-main>
      <el-footer>
        <div class="row">
          <div class="col-md-6">
              <h5>Холбоос</h5>
              <div class="row">

                  <div class="col-md-6">
                      <ul class="list links">
                          <li><a href="http://crc.gov.mn">Байгууллагын веб хуудас</a></li>
                          <li><a href="https://zipcode.mn/">Шуудангийн нэгдсэн кодын систем</a></li>
                          <li><a href="http://www.black-list.mn//">Зөрчилтэй домайны жагсаалт </a></li>
                      </ul>
                  </div>
                  <div class="col-md-6">
                      <ul class="list links">
                          <li><a href="http://www.facebook.com/crcmongol">Facebook холбоос</a></li>
                          <li><a href="http://www.twitter.com/crcmn">Twitter холбоос</a></li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col-md-6">
              <h5>Холбоо барих</h5>
              <div class="row">
                  <div class="col-md-6">
                      <div class="c-info" style="margin-top: 15px">
                          <i class="fa fa-map-marker"></i>
                          Метро бизнес төв А-блок 5 давхар Д.Сүхбаатарын гудамж-13 Сүхбаатар дүүрэг, Улаанбаатар 14201-0033
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="c-info">
                          <i class="fa fa-envelope-o"></i>
                          <a href="mailto:info@crc.gov.mn">info@crc.gov.mn</a>
                      </div>
                      <div class="c-info">
                          <i class="fa fa-phone"></i>
                          +976-11-304258
                          <br>
                          1800-1858
                      </div>
                      <div class="c-info">
                          <i class="fa fa-fax"></i>
                          +976-11-327720
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </el-footer>
    </el-container>
  </div> 
</template>

<script>
  export default {
    data () {
      return {
        loading: true,
        currentDate: '2021-06-01',
        lists: [],
        activeIndex: '',
        activeName: '',
        uploadData:{},
         url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg',
          'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
        ]
      }
    },
     mounted() {
      this.loading = false
      this.lists = [
        {
          imgUrl:
            'https://fuss10.elemecdn.com/a/3f/3302e58f9a181d2509f3dc0fa68b0jpeg.jpeg',
          name: 'Deer',
        },
        {
          imgUrl:
            'https://fuss10.elemecdn.com/1/34/19aa98b1fcb2781c4fba33d850549jpeg.jpeg',
          name: 'Horse',
        },
        {
          imgUrl:
            'https://fuss10.elemecdn.com/0/6f/e35ff375812e6b0020b6b4e8f9583jpeg.jpeg',
          name: 'Mountain Lion',
        },
      ]
    },
    methods: {
      setLoading() {
        this.loading = true
        setTimeout(() => (this.loading = false), 2000)
      },
      handleSelect(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClick(tab, event) {
        console.log(tab, event);
      },
      getUpload(page=1){
        axios
        .get("/home/getupload?page=1")
        .then((response) => {
            this.loading = false;
            this.uploadData = response.data;
        })
        .catch((error) => {
            this.loading = false;
            console.log(error.response);
            this.$notify.error({
                title: "Error",
                message: error.response.data.message,
            });
        });
      }
    },
    created() {
        this.getUpload();
    },
  }

</script>

<style>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.95;
    line-height: 300px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #d3dce6;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }

  .text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    width: 1000px;
  }

/* card image */
  .time {
    font-size: 13px;
    color: #999;
  }
  
  .bottom {
    margin-top: 10px;
    line-height: 9px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  
  .clearfix:after {
      clear: both
  }
</style>