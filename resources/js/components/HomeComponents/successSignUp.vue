<template>
    <div>
                <section class="solid_banner_area">
                    <div class="container">
                        <div class="solid_banner_inner">
                            <h3>Registrasi berhasil</h3>
                            <ul>
                                <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                                <li>
                                    <router-link :to="{name: 'LoginUser'}" >
                                    Login
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="emty_cart_area p_100">
                    <div class="container">
                        <div class="emty_cart_inner">
                            <h3>Terima kasih sudah bergabung bersama kami, sekarang anda dapat belanja apapun yang anda inginkan.</h3>
                            <h4>Kembali ke  <router-link :to="{name: 'LoginUser'}" >
                                    Login
                                    </router-link>
                                    </h4>
                        </div>
                    </div>
                </section>
    </div>
</template>