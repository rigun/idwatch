<template>
    <div>
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <form>
                            <div class="header">
                                Lupa Password
                            </div>
                            <div class="body">
                                <span>Masukkan Email Anda</span><br>
                                <input type="email" class="input inputEmail" v-model="email" required  @change="cekEmail()">
                                <p class="info" :class="{'success': valid, 'danger': !valid}"><span v-if="!valid && email != null">Email Tidak Terdaftar</span><span v-if="valid && email != null">Email Ditemukan</span></p>
                            </div>
                            <div class="footer">
                                <router-link :to="{name: 'LoginUser'}" class="btn btn-danger">
                                Kembali</router-link>
                                <button class="btn btn-primary">Kirim</button>
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
        }
    },
    methods:{
        cekEmail(){ //mengecek ketersediaan email
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(this.email == ''){
                    this.infoView = "none";
                        this.infoMessage = '';
                        this.valid = false;
                }else if( re.test(String(this.email).toLowerCase()) ){
                    let uri = '/api/user/email/'+this.email;
                    axios.get(uri).then((response) => {
                    if(response.data){
                        this.valid = true;
                    }else if(!response.data){
                        this.valid = false;
                    }
                    })
                }
            },
        sendEmail(){
    
            axios.post('/api/forgetpassword',{email: this.email}).then(response =>
            {
                alert('Link untuk reset password telah dikirimkan ke email anda.')
            }).catch(error =>{
                alert('coba lagi');
            })
        }
    }
}
</script>
