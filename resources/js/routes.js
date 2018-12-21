

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter)

//main
const Logout = Vue.component('logout', require('./components/LogoutComponent.vue'))
const LogoutAdmin = Vue.component('LogoutAdmin', require('./components/LogoutAdminComponent.vue'))

//layout
const HomeLayout = Vue.component('HomeLayout', require('./components/LayoutComponents/homeLayout.vue'))
const DashboardLayout = Vue.component('DashboardLayout', require('./components/LayoutComponents/dashboardLayout.vue'))

// home
const LandingPage = Vue.component('LandingPage', require('./components/HomeComponents/landingPage.vue'))
const LoginUser = Vue.component('LoginUser', require('./components/HomeComponents/loginUser.vue'))
const Contact = Vue.component('Contact', require('./components/HomeComponents/ContactUsPage.vue'))
const Shop = Vue.component('Shop', require('./components/HomeComponents/ShopPage.vue'))
const Cart = Vue.component('Cart', require('./components/HomeComponents/CartPage.vue'))
const Success = Vue.component('Success', require('./components/HomeComponents/successSignUp.vue'))

// dashboard
const DashboardContent = Vue.component('DashboardContent', require('./components/DashboardComponents/dashboardContent.vue'))
const LoginAdmin = Vue.component('LoginAdmin', require('./components/DashboardComponents/loginAdmin.vue'))
const MainContent = Vue.component('MainContent', require('./components/DashboardComponents/mainContent.vue'))
const AddContent = Vue.component('AddContent', require('./components/DashboardComponents/addContent.vue'))
const ReportContent = Vue.component('ReportContent', require('./components/DashboardComponents/reportContent.vue'))
const ConfirmContent = Vue.component('ConfirmContent', require('./components/DashboardComponents/confirmContent.vue'))
const routes = [
    {
        path: '/',
        component: HomeLayout,
        children: [
            {
                name: 'Landing',
                path: '',
                component: LandingPage
            },
            {
                name: 'LoginUser',
                path: 'login',
                component: LoginUser
            },
            {
                name: 'Contact',
                path: 'contact',
                component: Contact
            },
            {
                name: 'Shop',
                path: 'shop',
                component: Shop
            },
            {
                name: 'Cart',
                path: 'cart',
                component: Cart
            },
            {
                name: 'Success',
                path: 'success',
                component: Success
            }
        ]
      },
      {
          path: '',
          component: DashboardLayout,
          children:[
              {
                  path: '/dashboard',
                  component: DashboardContent,
                  children:[
                      {
                          name: 'DashboardContent',
                          path: '',
                          component: MainContent,
                      },
                      {
                            name: 'AddContent',
                            path: 'add',
                            component: AddContent,
                        },
                        {
                            name: 'ReportContent',
                            path: 'report',
                            component: ReportContent,
                        },
                        {
                            name: 'ConfirmContent',
                            path: 'confirm',
                            component: ConfirmContent,
                        },
                  ]
              },
              {
                  name: 'LoginAdmin',
                  path: '/admin/login',
                  component: LoginAdmin
              },
          ]
      },
  
    {
        name: 'Logout',
        path: '/logout',
        component: Logout,
      },
  
    {
        name: 'LogoutAdmin',
        path: '/logoutAdmin',
        component: LogoutAdmin,
      },
];
const router = new VueRouter({mode: 'history', routes: routes});
router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    // if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    //     // redirect to login page
    //     next({ name: 'Login' })
    //     return
    // }

    // if logged in redirect to dashboard
    if(to.path === '/dashboard' && !store.state.isLoggedIn) {
        next({ name: 'LoginAdmin' })
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/admin/login' && store.state.isLoggedIn) {
        next({ name: 'DashboardContent' })
        return
    }

    next()
})
export default router