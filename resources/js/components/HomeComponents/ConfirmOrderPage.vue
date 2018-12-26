<template>
    <div>
          <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Konfirmasi Pesanan</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><router-link :to="{name: 'CheckoutCart'}">Keranjang Checkout</router-link> </li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="emty_cart_area p_100">
            <div class="container">
                <div class="emty_cart_inner">
                    <h3>Pesanan Anda Telah Diterima</h3>
                    <p>Silahkan cek halaman <router-link :to="{name: 'CheckoutCart'}">keranjang checkout anda</router-link> untuk melihat rincian pesanan anda.
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>