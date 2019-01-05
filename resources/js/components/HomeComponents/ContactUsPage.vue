<template>
    <div>
   
        <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Contact</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="contact_area p_100">
            <div class="container">
                <div class="contact_title">
                    <h2>Get in Touch</h2>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui.</p>
                </div>
                <div class="row contact_details">
                    <div class="col-lg-4 col-md-6">
                        <div class="media">
                            <div class="d-flex">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <p>xxxxxxxxxx,<br />xxxxxxxxxx.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="media">
                            <div class="d-flex">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <a href="tel:+xxx-xxxx-xxx">+xxx-xxxx-xxx</a>
                                <a href="tel:+xxx-xxxx-xxx">+xxx-xxxx-xxx</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="media">
                            <div class="d-flex">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <a href="mailto:xxxxxxx@JAMTANGAN.com">xxxxxxx@JAMTANGAN.com</a>
                                <a href="mailto:xxxxxxx@JAMTANGAN.com">xxxxxxx@JAMTANGAN.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact_form_inner">
                    <h3>Drop a Message</h3>
                    <form class="contact_us_form row" @submit.prevent="sendEmail()">
                        <div class="form-group col-lg-4">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name *" v-model="name">
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address *" v-model="email">
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="text" class="form-control" id="subject" name="website" placeholder="Your Subject" v-model="subject">
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Type Your Message..." v-model="message"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <button type="submit" value="submit" class="btn update_btn form-control">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
      
    </div>
</template>
<script>
export default {
    data(){
        return{
            email: null,
            subject: null,
            name: null,
            message: null,
        }
    },
    methods:{
        sendEmail(){
            if(this.email == null || this.subject == null || this.name == null || this.message == null){
                alert("Silahkan lengkapi data-data yang kosong terlebih dahulu");
                return;
            }
            axios.post('/api/mail/contactus',{email: this.email, subject: this.subject, name: this.name, message: this.message}).then((response) =>{
                            alert('Terima kasih sudah menghubungi kami, pesan anda sudah kami terima.')
                        }).catch(error =>{
                            alert('Mohon maaf, terjadi kesalahan saat mencoba mengirimkan pesan. silahkan diperiksa lagi kelengkapan data yang dimasukkan.')
                        })
        }
    }
}
</script>