<template>
    <div>
        <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="sidebar">
                        <ul class="widget widget-menu unstyled">
                            <li><router-link :to="{name: 'DashboardContent'}"  ><i class="menu-icon icon-dashboard"></i>Dashboard</router-link></li>
                            <li><router-link :to="{name: 'Product'}"  ><i class="menu-icon icon-inbox"></i>Product</router-link></li>
                            <li><router-link :to="{name: 'ReportContent'}"  ><i class="menu-icon icon-inbox"></i>Laporan</router-link></li>
                            <li><router-link :to="{name: 'ConfirmContent'}"  ><i class="menu-icon icon-tasks"></i>Konfirmasi <b class="label orange pull-right">{{count}}</b> </router-link></li>
                            <li><router-link :to="{name: 'Brand'}"  ><i class="menu-icon icon-tasks"></i>Brand </router-link></li>
                        </ul>
                        <ul class="widget widget-menu unstyled">

                        </ul>
                        <ul class="widget widget-menu unstyled">
                            <li> <router-link :to="{name: 'LogoutAdmin'}"  >
                                <i class="menu-icon icon-signout"></i>Logout 
                                            </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="span9">
                    <div class="content">
                        <div id="dashboard">
                            <main class="homeContent">
                            <transition name="fade">
                            <router-view></router-view>
                            </transition>
                            </main>
                        </div>

                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            count: 0
        }
    },
    mounted(){
        this.unconfirmCount();
    },
    methods:{
  
        unconfirmCount(){ //mengambil jumlah data yang belum dikonfirmasi
             let uri = '/api/unconfirmCount';
            axios.get(uri).then((response) => {
                this.count = response.data;
            })
        }
    }
}
</script>