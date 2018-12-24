<template>
<div>
    <div v-if="!admin">
    </div>
    <div v-else>
       
        <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <i class="icon-reorder shaded"></i></a> <a class="brand" href="http://127.0.0.1:8000/"><img src="http://127.0.0.1:8000/images/img.jpg"
                        alt=""> </a>
                <div class="nav-collapse collapse navbar-inverse-collapse">

                    <form class="navbar-search pull-left input-append" v-if="token != null">
                        <input type="text" class="span3">
                        <button class="btn" type="button">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                    <ul class="nav pull-right" v-if="token != null" >
                        <li><a href="#">Admin </a></li>
                        <li class="nav-user dropdown" @click.prevent="togDrop()"><a class="dropdown-toggle" >
                                <img src="http://127.0.0.1:8000/images/user.png" class="nav-avatar" />
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu" :class="{'showDropdown': dropdown}">
                                <li class="divider"></li>
                                <li>
                                     <router-link :to="{name: 'LogoutAdmin'}"  >
                                                    Logout
                                            </router-link>
                                    </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav pull-right" v-if="token == null">
						<li><a>
							Forgot your password?
						</a></li>
					</ul>
                </div>
                <!-- /.nav-collapse -->
            </div>
        </div>
        <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->
    <div id="dashboard">
        <main class="homeContent">
        <transition name="fade">
        <router-view></router-view>
        </transition>
        </main>
    </div>
    </div>
</div>

</template>
<style>
.showDropdown{
    display: block;
}
</style>

<script>
export default {
    data(){
        return{
            admin: false,
            token: localStorage.getItem('token'),
            dropdown: false,
        }
    },
    mounted(){
        if(localStorage.getItem('roles') == 'user'){
            window.location = "http://127.0.0.1:8000";
        }else{
            this.admin= true;
              this.getUser();
        }
    },
        methods:{
            refresh(){
                 axios.get('/api/refresh', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    localStorage.setItem('token', response.data.access_token);
                    this.getUser();

                }).catch(error => {
                   this.mssg = 'Login';
                });
            },
            getUser(){
                axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response => {
                        if(response.data.status == "Token is Expired"){
                            this.$router.push({ name: 'LogoutAdmin' })
                        }else {
                           this.token = localStorage.getItem('token');
                           // this.getCountBag();                                
                        }
                    }).catch(error => {
                        this.mssg = 'Login';
                    })  
            },
            togDrop(){
                if(this.dropdown == false){
                    this.dropdown = true;
                }else{
                    this.dropdown = false;
                }
            }
        }
}
</script>