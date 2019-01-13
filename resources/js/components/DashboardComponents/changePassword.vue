<template>
    <div>
						<div class="module">
							<div class="module-head">
								<h3>Change Password</h3>
							</div>
							<div class="module-body">

									<form class="form-horizontal row-fluid"  @submit.prevent="sendData()">
										<div class="control-group">
											<label class="control-label" for="basicinput">Old Password</label>
											<div class="controls">
												<input type="password" id="basicinput" class="span8" v-model="data.password_lama">
											</div>
										</div>
										
										<div class="control-group">
												<label class="control-label" for="basicinput">New Password</label>
												<div class="controls">
													<input type="password" id="basicinput" class="span8" v-model="data.password_baru">
												</div>
											</div>
									
										<div class="control-group">
												<label class="control-label" for="basicinput">Retype New Password</label>
												<div class="controls">
													<input type="password" id="basicinput" class="span8" v-model="data.cpassword_baru">
                                                    <span style="color: red;" v-if="data.password_baru != null && data.cpassword_baru != null && data.password_baru!= data.cpassword_baru">Your password incorrect</span>

												</div>
											</div>
									

										<div class="control-group">
											<div class="controls">
												
												<button type="submit" class="btn btn-primary"><div class="loader" v-if="load"></div> <span v-else>Change</span> </button>
											</div>
										</div>
									</form>
							</div>
						</div>
    </div>
</template>
<script>
export default {
    data(){
        return{
           data:{
               password_lama: null,
               password_baru: null,
               cpassword_baru: null,
           },
           load: false,
        }
    },
    methods:{
        sendData(){
            this.load = true;
            if(!this.cek){
                alert('data invalid');
            this.load = false;

                return;
            }
            let uri= '/api/renewPassword'
            axios.post(uri,this.data,{
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
            }).then(response=>{
          
                alert(response.data.msg);
               location.reload();
            this.load = false;
            }).catch(error =>{
                alert('error');
            this.load = false;

            })
        }
	},
	computed: {
            cek(){ //mengecek valid tidaknya inputan
            if(this.data.password_baru!= null && this.data.cpassword_baru != null && this.data.password_lama != null){
                    if(this.data.password_baru == this.data.cpassword_baru){
                        return true;
                    }else{
                        return false;
                    }
                }
                return false;
            }
        }
}
</script>