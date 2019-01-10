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

                   
                    <ul class="nav pull-right" v-if="token != null" >
                        <li class="nav-user dropdown" @click.prevent="togDrop()"><a class="dropdown-toggle" >
                            <a href="#">Admin </a>
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu" :class="{'showDropdown': dropdown}">
                                <li> <router-link :to="{name: 'ChangePassword'}">
                                        Change Password
                                    </router-link></li>
                                <li class="divider"></li>
                                <li>
                                     <router-link :to="{name: 'LogoutAdmin'}"  >
                                                    Logout
                                            </router-link>
                                    </li>
                            </ul>
                        </li>
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
        if(localStorage.getItem('roles') == 'user'){ //apabila role pengguna adalah user
            window.location = "http://127.0.0.1:8000"; //akan diarahkan ke alamat yang ditentukan.
        }else{
            this.admin= true;
              this.getUser(); // mengambil data pengguna
        }
    },
        methods:{
            refresh(){ //melakukan refresh token pengguna
                 axios.get('/api/refresh', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    console.log(response);
                    if(response.data.message == "Unauthenticated" || response.data.message == 'Authorization Token not found'){
                        this.$router.push({ name: 'LogoutAdmin' }) //akan diarahkan ke komponen logoutAdmin 
                    }
                    localStorage.setItem('token', response.data.access_token);
                     this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                        this.getUser();
                    })

                }).catch(error => {
                   this.mssg = 'Login';
                });
            },
            getUser(){ //mengambil data pengguna
                axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response => {
                        if(response.data.status == "Token is Expired"){ //apabila tokennya kadaluarsa
                            this.$router.push({ name: 'LogoutAdmin' }) //akan diarahkan ke komponen logoutAdmin 
                        }else{
                           this.token = localStorage.getItem('token');
                           // this.getCountBag();                                
                        }
                    }).catch(error => {
                        this.mssg = 'Login';
                    })  
            },
            togDrop(){ //mengaktifkan dropdown
                if(this.dropdown == false){
                    this.dropdown = true;
                }else{
                    this.dropdown = false;
                }
            }
        }
}
</script>