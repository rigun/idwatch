

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
const DetailPage = Vue.component('DetailPage', require('./components/HomeComponents/DetailPage.vue'))
const ListItem = Vue.component('ListItem', require('./components/HomeComponents/ListItemShop.vue'))
const ListCategory = Vue.component('ListCategory', require('./components/HomeComponents/ListCategory.vue'))
const SearchList = Vue.component('SearchList', require('./components/HomeComponents/searchListPage.vue'))
const Checkout = Vue.component('Checkout', require('./components/HomeComponents/CheckoutPage.vue'))
const ConfirmOrder = Vue.component('ConfirmOrder', require('./components/HomeComponents/ConfirmOrderPage.vue'))
const CheckoutCart = Vue.component('CheckoutCart', require('./components/HomeComponents/CheckoutCart.vue'))
const AboutUs = Vue.component('AboutUs', require('./components/HomeComponents/AboutUs.vue'))
const Order = Vue.component('Order', require('./components/HomeComponents/Order.vue'))
const Forget = Vue.component('Forget', require('./components/HomeComponents/ForgetPassword.vue'))
const ChangeForget = Vue.component('ChangeForget', require('./components/HomeComponents/ChangePassword.vue'))

// dashboard
const DashboardContent = Vue.component('DashboardContent', require('./components/DashboardComponents/dashboardContent.vue'))
const LoginAdmin = Vue.component('LoginAdmin', require('./components/DashboardComponents/loginAdmin.vue'))
const MainContent = Vue.component('MainContent', require('./components/DashboardComponents/mainContent.vue'))
const AddContent = Vue.component('AddContent', require('./components/DashboardComponents/addContent.vue'))
const ReportContent = Vue.component('ReportContent', require('./components/DashboardComponents/reportContent.vue'))
const ConfirmContent = Vue.component('ConfirmContent', require('./components/DashboardComponents/confirmContent.vue'))
const TrashContent = Vue.component('TrashContent', require('./components/DashboardComponents/trashContent.vue'))
const DetailContent = Vue.component('DetailContent', require('./components/DashboardComponents/detailContent.vue'))
const Discount = Vue.component('Discount', require('./components/DashboardComponents/addDiscount.vue'))
const ChangePassword = Vue.component('Discount', require('./components/DashboardComponents/changePassword.vue'))
const Product = Vue.component('Product', require('./components/DashboardComponents/productComponent.vue'))
const Brand = Vue.component('Brand', require('./components/DashboardComponents/brandComponent.vue'))
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
                name: 'Forget',
                path: 'forgetpassword',
                component: Forget
            },
            {
                name: 'ChangeForget',
                path: 'verifforgetpassword/:status',
                component: ChangeForget
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
                name: 'Order',
                path: 'caraorder',
                component: Order
            },
            {
                name: 'CheckoutCart',
                path: 'checkoutcart',
                component: CheckoutCart
            },
            {
                name: 'ListCategory',
                path: 'list/:type/:category',
                component: ListCategory
            },
            {
                name: 'Checkout',
                path: 'checkout/:token',
                component: Checkout
            },
            {
                name: 'ConfirmOrder',
                path: 'confirm',
                component: ConfirmOrder
            },
            {
                name: 'SearchList',
                path: 'search/:search',
                component: SearchList
            },
            {
                path: 'shop',
                component: Shop,
                children:[
                    {
                        name: 'Shop',
                        path: ':type/:category',
                        component: ListItem,
                    }
                ]
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
            },
            {
                name: 'AboutUs',
                path: 'tentangkami',
                component: AboutUs
            },
            {
                name: 'DetailPage',
                path: 'detail/:slug',
                component: DetailPage
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
                  meta: { requiresAuth: true },
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
                        {
                            name: 'TrashContent',
                            path: 'trash',
                            component: TrashContent,
                        },
                        {
                            name: 'DetailContent',
                            path: 'detail/:id',
                            component: DetailContent,
                        },
                        {
                            name: 'Discount',
                            path: 'discount',
                            component: Discount,
                        },
                        {
                            name: 'ChangePassword',
                            path: 'changepassword',
                            component: ChangePassword,
                        },
                        {
                            name: 'Product',
                            path: 'product',
                            component: Product,
                        },
                        {
                            name: 'Brand',
                            path: 'brand',
                            component: Brand,
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
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'LoginAdmin' })
        return
    }

   
    if(to.name == 'LoginAdmin' && store.state.isLoggedIn) {
        next({ name: 'DashboardContent' })
        return
    }
    if(to.name == 'LoginUser' && store.state.isLoggedIn) {
        next({ name: 'Cart' })
        return
    }

    next()
})
export default router