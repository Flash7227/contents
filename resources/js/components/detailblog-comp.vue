<template>
    <div>
      <h1>
    
        
      </h1>
      

    </div>
</template>

<script>


 export default {
    data () {
      return {
        datas:{},
       
        
      }
    },
    methods: {
      
      blogDetails(){
        axios.get("/blog/details/{id}")
        .then((response) => {
            this.loading = false;
            if(response.data[0]){
                //console.log(response.data[0]);
                this.datas=response.data[0]
                console.log(this.data)
               
            }else{
                console.log(response.data);
                
            }
        })
        .catch((error) => {
            console.log(error.response);
            this.$notify.error({
                title: "Error",
                message: error.response.data.message,
            });
        });

      },
      created(){
        blogDetails();
      }
    }
 }
</script>