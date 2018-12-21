<template>
    <div>
                <section class="solid_banner_area">
                    <div class="container">
                        <div class="solid_banner_inner">
                            <h3>Registration Success</h3>
                            <ul>
                                <li><a href="#">Home</a></li>
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
                            <h3>Thank you for join with us, now you can login and buy everything you want.</h3>
                            <h4>back to   <router-link :to="{name: 'LoginUser'}" >
                                    Login
                                    </router-link>
                                    </h4>
                        </div>
                    </div>
                </section>
    </div>
</template>