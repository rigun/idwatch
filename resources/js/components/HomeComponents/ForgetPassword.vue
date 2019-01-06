<template>
    <div>
        <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Login</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a href="track.html">Login</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="login_area p_100">
            <div class="container">
                <div class="login_inner">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="login_title">
                                <h2>log in your account</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus accumsan rhoncus porta.</p>
                            </div>
                            <form class="login_form row" v-on:submit.prevent="loginAkun()">
                                <div class="col-lg-12 form-group">
                                    <input class="form-control" type="email" placeholder="Email" v-model="login.email">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input class="form-control" type="password" placeholder="Password" v-model="login.password">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="creat_account">
                                        <input type="checkbox" id="f-option" name="selector" v-model="login.remember">
                                        <label for="f-option">Remember Email</label>
                                        <div class="check"></div>
                                    </div>
                                    <h4>Forgot your password ?</h4>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" value="submit" class="btn update_btn form-control">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8">
                            <div class="login_title">
                                <h2>create account</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus accumsan rhoncus porta. Ut pulvinar in leo sed porta. Fusce a pretium sem.</p>
                            </div>
                            <form class="login_form row" v-on:submit.prevent="registerAkun()">
                                <div class="col-lg-6 form-group">
                                    <input class="form-control" type="text" placeholder="Name" v-model="register.name">
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input class="form-control" type="tel" placeholder="Phone" v-model="register.phone">
                                    <span class="is-danger" v-if="isNaN(register.phone)">Please input the correct phone number</span>                                    
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input class="form-control" type="email" placeholder="Email" v-model="register.email" @change="cekEmail">
                                    <span :class="{'is-danger': infoView == 'is-danger', 'is-success': infoView == 'is-success'}" v-if="infoMessage != ''">{{infoMessage}}</span>                                    
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input class="form-control" type="password" placeholder="Password" v-model="register.password">
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input class="form-control" type="password" placeholder="Re-Password" v-model="register.cpassword">
                                    <span style="color: red;" v-if="register.password != null && register.cpassword != null && register.password!= register.cpassword">Your password incorrect</span>
                                </div>
                                <div class="col-lg-12 form-group">
                                    
                                    <button type="submit" value="submit" class="btn subs_btn form-control">Daftar Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
     <v-snackbar
            v-model="snackbar"
            :bottom="true"
            :multi-line="true"
            :timeout="timeout"
            >
            {{ text }}
            <v-btn
                color="pink"
                flat
                @click="snackbar = false"
            >
                Close
            </v-btn>
            </v-snackbar>
    </div>
</template>
<style>
.is-danger{
    color: red;
}
.is-success{
    color: green;
}
</style>

<script>
import store from '../../store'
export default {
    data(){
        return{
            register: {
                name: null,
                email: null,
                password: null,
                cpassword: null,
                phone: null,
            },

            valid: 0,
            infoMessage: "none",
            infoMessage: '',
            login: {
                email: localStorage.getItem('email'),
                password: null,
                remember: localStorage.getItem('remember'),
            },
            snackbar: false,
            timeout: 2000,
            text: '',
        }
    },
    methods: {
        cekEmail(){ //mengecek ketersediaan email
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(this.register.email == ''){
                    this.infoView = "none";
                        this.infoMessage = '';
                        this.valid = 0;
                }else if( re.test(String(this.register.email).toLowerCase()) ){
                    let uri = '/api/user/email/'+this.register.email;
                    axios.get(uri).then((response) => {
                    if(response.data){
                        this.valid = 0;
                        this.infoView = "is-danger";
                        this.infoMessage = "Email already used"
                    }else if(!response.data){
                        this.valid = 1;
                        this.infoView = "is-success";
                        this.infoMessage = "Email is ready"
                    }
                    })
                }else{
                    this.valid = 0;
                    this.infoView = "is-danger";
                    this.infoMessage = "Email not valid"
                }

            },
       
        loginAkun(){ //login pengguna
            axios.post('/api/auth/login', {
                email: this.login.email,
                password: this.login.password
            }).then(response => {
                store.commit('loginUser') //membuat store atau penyimpnaan dibagian internal browser dengan vuex
                localStorage.setItem('token', response.data.access_token)
                localStorage.setItem('roles', response.data.role)
                if(this.login.remember){
                    localStorage.setItem('email', this.login.email)
                    localStorage.setItem('remember', this.login.remember)
                }
                this.$router.push({ name: 'Cart' })
            }).catch(error => {
                this.snackbar = true;
                this.text = "Incorrect Username or Password"
            });
        },
       
    },
  
}
</script>
