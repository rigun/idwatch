<template>
    <div>
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <form @submit.prevent="updatePassword()">
                            <div class="header">
                               Ubah Password
                            </div>
                            <div class="body">
                                <span>Password Baru Anda</span><br>
                                <input type="password" class="input inputEmail" v-model="password_baru" required  @change="cekPassword()">
                                <span>Konfirmasi Password Baru Anda</span><br>
                                <input type="password" class="input inputEmail" v-model="cpassword_baru" required  @change="cekPassword()">
                                    <span style="color: red;" v-if="password_baru != null && cpassword_baru != null && password_baru!= cpassword_baru">Password tidak sama</span>

                            </div>
                            <div class="footer">
                                <button class="btn btn-primary">Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.columns{
    background: transparent;
}
    .column{
        width: 100%;
    }
    .card{
        width: 300px;
        margin: auto;
        background: transparent;
        border: none;
    }
    .card-content{
        border-radius: 5px;
        background: white;
        display: block;
    }
    .card-content .body{
        padding: 10px;
        background: white;
    }
    .card-content .header{
        padding: 10px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
        background: #f3f3f3;
    }
    .card-content .footer{
        padding: 10px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        display: flex;
    }
    .card-content input{
        width: 100%;
        background: white;
        border: 1px solid black;
        border-radius: 8px;
        margin: 10px auto;
        padding: 5px;
    }
    .card-content .footer .btn-danger{
        margin-left: auto;
    }
    .card-content .footer .btn-primary{
        margin-left: 10px;
    }
</style>
<script>
export default {
    data(){
        return{
            email: null,
            valid: false,
            password_baru: null,
            cpassword_baru: null,
        }
    },
    methods:{
        updatePassword(){
            if(!cek){
                alert('Password tidak sesuai');
                return;
            }
            axios.post('/api/updatepassword/forget/'+this.$route.params.status,{password: this.password_baru}).then(response =>
            {
                alert('Link untuk reset password telah dikirimkan ke email anda.')
            }).catch(error =>{
                alert('coba lagi');
            })
        }
    }, 
    computed:{
        cek(){ //mengecek valid tidaknya inputan
            if(this.password_baru!= null && this.cpassword_baru){
                if(this.password_baru == this.cpassword_baru ){
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
