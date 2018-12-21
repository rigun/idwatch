<template>
    <div>
       <div class="wrapper">
		<div class="container">
            
			<div class="row">

            	<div class="module module-login span4 offset4">
   
					<form class="form-vertical" @submit.prevent="loginAkun()">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" id="inputEmail" placeholder="Email" v-model="login.email">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="password" id="inputPassword" placeholder="Password" v-model="login.password">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button class="btn btn-primary pull-right"> <div class="loader" v-if="load"></div> <span v-else>Login</span> 
								</button>
									<label class="checkbox">
										<input type="checkbox" v-model="login.remember"> Remember Email
									</label>
								</div>
							</div>
						</div>
					</form>
                    	  
				</div>
                               <div class="alert alert-danger span4 offset4" role="alert" style="padding: 20px 0px;text-align: center;" v-if="text != null">
                    {{text}}
                    </div>
			</div>
		</div>
	</div>
    </div>
</template>
<script>
import store from '../../store'

export default {
    data(){
        return{
            login: {
                email: localStorage.getItem('email'),
                password: null,
                remember: localStorage.getItem('remember'),
            },
            text: null,
            load: false,
        }
    },
    methods:{
                loginAkun(){
                    this.load = true;
            axios.post('/api/auth/login', {
                email: this.login.email,
                password: this.login.password
            }).then(response => {
                if(response.data.role == 'user'){
                    this.text = "Only admin can login from here"
                }else{
                    store.commit('loginUser')
                    localStorage.setItem('token', response.data.access_token)
                    localStorage.setItem('roles', response.data.role)
                    if(this.login.remember){
                        localStorage.setItem('email', this.login.email)
                        localStorage.setItem('remember', this.login.remember)
                    }
                    this.$router.push({ name: 'DashboardContent' })
                }
                this.load = false;
            }).catch(error => {
                this.load = false;
                this.text = "Incorrect Username or Password"
            });
        }
    }
}
</script>