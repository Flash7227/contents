

<template>
    <div >
      <el-card>
        <el-image  
          :src="'/storage/uploads/' + info.profile" 
          :preview-src-list="avatar">
        </el-image>
        <el-descriptions class="margin-top" title="" :column="1" border>
        <el-descriptions-item>
          <template slot="label">
          <i class="el-icon-user"></i>
          Нэр
          </template>
          {{ this.info.name }}
          </el-descriptions-item>
          <el-descriptions-item>
            <template slot="label">
              <i class="el-icon-files"></i>
            </template>
              {{ roleValue(this.info.role) }}
            
          </el-descriptions-item>
          
          <el-descriptions-item>
            <template slot="label">
              <i class="el-icon-notebook-2"></i>
              И-мэйл
            </template>
            {{ this.info.email }}
          </el-descriptions-item>
          <el-descriptions-item>
            <template slot="label">
              <i class="el-icon-notebook-2"></i>
              Үйлдэлийн эрх
            </template>
            {{ permissionsValue(this.info.permissions) }}
          </el-descriptions-item>
          <el-descriptions-item>
            <template slot="label">
              <i class="el-icon-notebook-2"></i>
              Ашиглах боломтой дата хэмжээ
            </template>
            {{ storageLimitValue(this.info.storage_limit) }}
          </el-descriptions-item>
          <el-descriptions-item>
            <template slot="label">
              <i class="el-icon-date"></i>
              Үүсгэсэн огноо
            </template>
            {{ dateformatter(this.info.created_at) }}
          </el-descriptions-item>
        </el-descriptions>
        <el-button
                  type="primary"
                  icon="el-icon-picture"
                  style="margin-top:12px;"
                  round
                  plain
                  @click="imageModal()">зураг солих</el-button>
      </el-card>

      <el-form :model="current" label-width="50px" class="demo-form">
        <div class="modal fade" id="img" tabindex="-1" aria-labelledby="imgLabel"   aria-hidden="true">     
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imgLabel">Профайл зураг солих</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <el-col :span="20">
                <div class="form-group">
                </div>
                <el-form-item label="" prop="role_id">
                <el-upload
                ref="upload"
                action="/createuser/user/image"
                list-type="picture-card"
                :file-list="attachments"
                :data="fileList"
                :auto-upload="false"
                :limit="1"
                accept="image/jpeg,image/gif,image/png"
                :on-exceed="handleExceed"
                :multiple="false"
                :headers="{ 'X-CSRF-TOKEN': csrf }"
                :on-success="handleSuccess"
                :on-error="handleError"
                style="margin-left: auto;
                      margin-right: auto;
                      text-align: center;
                      vertical-align: middle;"
                >
                <el-button slot="trigger" size="small" type="text" icon="el-icon-plus"></el-button>
                </el-upload>
                </el-form-item>
                </el-col>
              </div>
              <div class="modal-footer">
                <el-button
                  style="margin-left: 10px;"
                  type="success"
                  round
                  plain
                  @click="submitUpload"
                  icon="el-icon-upload2"
                >Хадгалах</el-button>
                <el-button type="info" plain round data-dismiss="modal">Цуцлах</el-button>
              </div>
            </div>
          </div>
        </div>
      </el-form>
    </div>
</template>

<script>

  export default {
    data() {
      return {
         
        info: {
          id:'',
          name: '',
          permissions: [],
          role: '',
          email: '',
          storage_limit:''
        },
        
        avatar: [],
        attachments: [],
        fileList: {
          dataType: "0",     
          oldFilePath: ""
        },
        current: {
          id:'',

        },

      };
    },
    methods: {
      profile() {
            axios.get("/admin/profile/upload")
                .then((response) => {
                    this.info = response.data[0];
                    this.avatar = response.data[1];
                })
                .catch((error) => {
                    console.log(error.response);
                    this.$notify.error({
                        title: "Error",
                        message: error.response.data.message,
                    });
                });
        },
      dateformatter(date) {
          return moment(date).format("YYYY-MM-DD");
      },

       // ~~~~~~~~~~~~~~~~~~~~~~~~~~~UPLOAD start~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    imageModal(){
        $('#img').modal('show');
        this.current.id = this.info.id;
        this.fileList.id = this.info.id;
        console.log(this.info.id);
        this.$emit('toReload');
    },
    addAttachment(file, fileList) {
        this.attachments.push(file);
        console.log(file);
        // console.log(fileList);
    },
    handleExceed(files, fileList) {
        this.$message({
            message:
                "Нэг дор уншуулах файлын тоо нэг болохыг анхаарна уу! Өөр файл сонгох бол өмнөх файлыг арилгана уу!",
            type: "warning",
            duration: 4000
        });
    },
    handleSuccess() {
        this.loading = false;
        this.$message({
            message: "Амжилттай хадгаллаа!",
            type: "success",
            duration: 3000
        });
        $('#img').modal('hide');
        this.$refs.upload.clearFiles();
        this.$emit('toReload');
    },
    handleError() {
        this.loading = false;
        this.$message({
            message: "Алдаа гарлаа!",
            type: "error",
            duration: 3000
        });
        this.$emit('toReload');
    },
    addAttachment(file, fileList) {
        this.attachments.push(file);
        console.log(file);
        // console.log(fileList);
    },
    submitUpload() {
        //;console.log(this.fileList);
        this.loading = true;
        this.$refs.upload.submit();
    },
     // ~~~~~~~~~~~~~~~~~~~~~~~~~~~UPLOAD end~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 
        storageLimitValue(value){
            if(value != 0){
                var i = Math.floor( Math.log(value) / Math.log(1024) );
                return ( value / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
            }     
            if(value == 0){
                return value = '0';
            }else{
                return value = value;
            }
        },

        permissionsValue(data){
            if(data){
                return data.join(', ');
            }
            return data;
        },

        roleValue(value){
             
            if(value === null){
                return value = 'null';
            }else if(value === 1){
                return value = 'Админ';
            }else if(value === 0){
                return value = 'Энгийн хэрэглэгч';
            }else if(value === 2){
                return value == 'Дотоод ажилтан';
            }else{
                return value === 'Хоосон'
            }
        },
    },

    

    created() {
      this.$on('toReload',() => {
          this.profile();
      });
  },
  mounted(){
      this.profile();
  },
  props: {
        csrf: {
            type: String
        }
    }
  };
  
</script>
<style scoped>
  .el-card {
    background: none;
    padding: 10px;
    text-align: center;
    width:450px;
    margin-left:80px;
    margin-top:20px;

  }
  .el-image{
    width: 100px;
    height:100px;
    border: black;
  }
  
  .span {
    text-align:left;
    font-size:18px;
  }
</style>
