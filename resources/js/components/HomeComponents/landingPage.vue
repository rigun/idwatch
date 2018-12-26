<template>
    <div>
 <section class="home_carousel_area">
        <div class="home_carousel_slider owl-carousel">
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-1.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>mens bag</h3>
                        <h4>We feature the best professional bags </h4>
                        <h5>Including:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                        <a class="discover_btn" href="#">discover now</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-2.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>mens bag</h3>
                        <h4>We feature the best professional bags </h4>
                        <h5>Including:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                        <a class="discover_btn" href="#">discover now</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-3.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>mens bag</h3>
                        <h4>We feature the best professional bags </h4>
                        <h5>Including:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                        <a class="discover_btn" href="#">discover now</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-4.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>mens bag</h3>
                        <h4>We feature the best professional bags </h4>
                        <h5>Including:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                        <a class="discover_btn" href="#">discover now</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-5.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>mens bag</h3>
                        <h4>We feature the best professional bags </h4>
                        <h5>Including:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                        <a class="discover_btn" href="#">discover now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fillter_latest_product">
        <div class="container">
            <div class="single_c_title">
                <h2>Produk Per Kategory</h2>
            </div>
            <div class="fillter_l_p_inner">
                <ul class="fillter_l_p">
                    <li v-for="category in categories" :key="category.id" :class="{'active': selectedCategory == category.name}" style="cursor:pointer;"><a @click.prevent="selectedCategory = category.name">{{category.name}}</a></li>
                </ul>
                <div class="row isotope_l_p_inner">
                    <div class="col-lg-3 col-md-4 col-sm-6" v-for="item in showByCategory" :key="item.id">
                        <div class="l_product_item">
                            <div class="l_p_img">
                                 <router-link :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                    <img class="img-fluid" :src="'./itemImages/'+item.picture[0].filename" alt="">
                                            </router-link>
                            </div>
                            <div class="l_p_text">
                                <ul>
                                    <li class="p_icon">   
                                                     <i class="icon_piechart"></i>
                                           </li>
                                    <li><router-link  class="add_cart_btn" :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                            Add To Cart
                                            </router-link></li>
                                    <li class="p_icon"><a href="#"><i class="icon_heart_alt"></i></a></li>
                                </ul>
                                <h4>{{item.name}}</h4>
                                <h5><del></del> Rp {{item.price}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</template>
<style>
.isotope_l_p_inner{
    height: auto !important;
    padding: 1px;
}
</style>

<script>
export default {
    data(){
        return{
            interval: null,
             items: [],
             selectedCategory: 'Man',
             categories: [],
        }
    },
    created(){
        
    },
    destroyed(){
           clearInterval(this.interval);
    },
    mounted(){
        this.$parent.refresh();
        this.interval = setInterval(() => this.$parent.refresh(), 900000);
        this.$nextTick(function () {
                    this.getSlider();
                })
            this.getCategory();

            this.getData();

    

    },
    computed:{
        showByCategory(){
             if(this.items.length > 0) {
                    return this.items.filter((row, index) => {
                            if(row.category.name == this.selectedCategory){
                                return true;
                            }
                      });
                }
        }
    },
    methods:{
        getCategory(){
            let uri = '/api/category';
            axios.get(uri).then((response) => {
                this.categories = response.data;
            });
		},
         getData(){
            let uri = '/api/item';
            axios.get(uri).then((response) => {
                this.items = response.data;
                
            })
            
        },
        getSlider(){
    ;(function($) {
    "use strict";
    
//    var nav_offset_top = $('header').height(); 
//    /*-------------------------------------------------------------------------------
//	  Navbar 
//	-------------------------------------------------------------------------------*/
//
//	//* Navbar Fixed  
//    function navbarFixed(){
//        if ( $('.main_menu_area, .search_area').length ){ 
//            $(window).scroll(function() {
//                var scroll = $(window).scrollTop();   
//                if (scroll >= nav_offset_top ) {
//                    $(".main_menu_area, .search_area").addClass("navbar_fixed");
//                } else {
//                    $(".main_menu_area, .search_area").removeClass("navbar_fixed");
//                }
//            });
//        };
//    };
//    navbarFixed();
    
    
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function main_slider(){
        if ( $('#main_slider').length ){
            $("#main_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:false,
                        hide_onmobile:true,
                        hide_under:820,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        }
                    },
                },
                responsiveLevels:[4096,1199,992,767,480],
                gridwidth:[1170,1000,750,700,300],
                gridheight:[575,575,575,600,500],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    main_slider();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function product_slider(){
        if ( $('#product_slider').length ){
            $("#product_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    keyboardNavigation:"off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    onHoverStop:"off",
                    arrows: {
                        style:"uranus",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:778,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                    ,
                    thumbnails: {
                        style:"erinyen",
                        enable:true,
                        width:80,
                        height:105,
                        min_width:80,
                        wrapper_padding:0,
                        wrapper_color:"#fff",
                        wrapper_opacity:"1",
                        tmp:'<span class="tp-thumb-over"></span><span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>',
                        visibleAmount:10,
                        hide_onmobile:false,
                        hide_onleave:false,
                        direction:"horizontal",
                        span:true,
                        position:"outer-bottom",
                        space:17,
                        h_align:"center",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                },
                gridwidth:370,
                gridheight:520,
                lazyType:"none",
                shadow:0,
                spinner:"spinner2",
                stopLoop:"on",
                stopAfterLoops:0,
                stopAtSlide:1,
                shuffle:"off",
                autoHeight:"off",
                disableProgressBar:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    product_slider();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function product_slider2(){
        if ( $('#product_slider2').length ){
            $("#product_slider2").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    keyboardNavigation:"on",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    onHoverStop:"off",
                    touch:{
                        touchenabled:"on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    }
                    ,
                    arrows: {
                        style:"hesperiden",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:778,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:200,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                    ,
                    thumbnails: {
                        style:"gyges",
                        enable:true,
                        width:78,
                        height:104,
                        min_width:100,
                        wrapper_padding:0, 
                        wrapper_color:"#fff",
                        wrapper_opacity:"1",
                        tmp:'<span class="tp-thumb-img-wrap">  <span class="tp-thumb-image"></span></span>',
                        visibleAmount:5,
                        hide_onmobile:false,
                        hide_over:777,
                        hide_onleave:false,
                        direction:"vertical",
                        span:true,
                        position:"outer-left",
                        space:15,
                        h_align:"left",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                    ,
                    tabs: {
                        style:"gyges",
                        enable:true,
                        width:100,
                        height:105,
                        min_width:100,
                        wrapper_padding:0,
                        wrapper_color:"#fff",
                        wrapper_opacity:"0",
                        tmp:'<div class="tp-tab-content">  <span class="tp-tab-date">{{param1}}</span>  <span class="tp-tab-title">{{title}}</span></div><div class="tp-tab-image"></div>',
                        visibleAmount: 10,
                        hide_onmobile: true,
                        hide_under:778,
                        hide_onleave:false,
                        hide_delay:200,
                        direction:"vertical",
                        span:true,
                        position:"outer-left",
                        space:0,
                        h_align:"left",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                },
                gridwidth:370,
                gridheight:520,
                lazyType:"none",
                shadow:0,
                spinner:"spinner2",
                stopLoop:"on",
                stopAfterLoops:0,
                stopAtSlide:1,
                shuffle:"off",
                autoHeight:"off",
                disableProgressBar:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    product_slider2();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function fullwidth_slider(){
        if ( $('#fullwidth_slider').length ){
            $("#fullwidth_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:false,
                        hide_onmobile:true,
                        hide_under:820,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        }
                    },
                },
                responsiveLevels:[4096,1320,1199,992,767,480],
                gridwidth:[1380,1170,960,720,700,300],
                gridheight:[900,900,800,700,500,500],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    fullwidth_slider();
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function home_box_slider(){
        if ( $('#home_box_slider').length ){
            $("#home_box_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:50000000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:true,
                        hide_onmobile:true,
                        
                        left: {
                            h_align: "right",
                            v_align: "bottom",
                            h_offset: 60,
                            v_offset: 10
                        },
                        right: {
                            h_align: "right",
                            v_align: "bottom",
                            h_offset: 10,
                            v_offset: 10
                        }
                    },
                },
                responsiveLevels:[4096,1320,1199,992,767,480],
                gridwidth:[870,870,870,720,700,350],
                gridheight:[450,450,450,450,450,410],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    home_box_slider();
  
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function l_product_slider(){
        if ( $('.l_product_slider').length ){
            $('.l_product_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 4,
                nav:true,
                autoplay: true,
                smartSpeed: 1500,
                dots:false,
                navContainerClass: 'l_product_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    }
                }
            })
        }
    }
    l_product_slider();
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function home_l_product_slider(){
        if ( $('.home_l_product_slider').length ){
            $('.home_l_product_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 3,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:false,
                navContainerClass: 'home_l_product_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    992: {
                        items: 2,
                    },
                    1200: {
                        items: 3,
                    }
                }
            })
        }
    }
    home_l_product_slider();
   
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function carousel_slider(){
        if ( $('.home_carousel_slider').length ){
            $('.home_carousel_slider').owlCarousel({
                loop:true,
                margin: 0,
                items: 5,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:true, 
                navContainer: '.home_carousel_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    800: {
                        items: 3,
                    },
                    1200: {
                        items: 5,
                    }
                }
            })
        }
    }
    carousel_slider();
    
   
    
    /*----------------------------------------------------*/
    /*  portfolio_isotope
    /*----------------------------------------------------*/
    function main_gallery(){
        if ( $('.fillter_slider_inner, .isotope_l_p_inner').length ){
            // Activate isotope in container
            $(".fillter_slider_inner, .isotope_l_p_inner").imagesLoaded( function() {
                $(".fillter_slider, .isotope_l_p_inner").isotope({
                    layoutMode: 'masonry',
                    percentPosition:true,
                    columnWidth: 1
        //            masonry: {
        //                columnWidth: '.grid-sizer, .grid-sizer_two',
        //            }            
                }); 
            }); 
        }
    }
    main_gallery();
    
    
    /*----------------------------------------------------*/
    /*  Isotope Fillter js
    /*----------------------------------------------------*/
    function portfolio_isotope(){
        if ( $('.portfolio_filter li, .fillter_l_p li').length ){
            // Add isotope click function
            $(".portfolio_filter li, .fillter_l_p li").on('click',function(){
                $(".portfolio_filter li, .fillter_l_p li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $(".fillter_slider .owl-item, .isotope_l_p_inner, .fillter_product_slider .owl-item, .home_l_product_slider .owl-item").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    }
    
    portfolio_isotope();
    
    
    /*----------------------------------------------------*/
    /*  Language Flag js 
    /*----------------------------------------------------*/
    function createByJson() {
        var jsonData = [					
            {description:'Choos your payment gateway', value:'', text:'Payment Gateway'},					
            {image:'../img/icon/flag-1.png', description:'My life. My card...', value:'amex', text:'Amex'},
            {image:'../img/icon/flag-1.png', description:'It pays to Discover...', value:'Discover', text:'Discover'},
            {image:'../img/icon/flag-1.png', title:'For everything else...', description:'For everything else...', value:'Mastercard', text:'Mastercard'},
            {image:'../img/icon/flag-1.png', description:'Sorry not available...', value:'cash', text:'Cash on devlivery', disabled:true},
            {image:'../img/icon/flag-1.png', description:'All you need...', value:'Visa', text:'Visa'},
            {image:'../img/icon/flag-1.png', description:'Pay and get paid...', value:'Paypal', text:'Paypal'}
        ];
        $("#byjson").msDropDown({byJson:{data:jsonData, name:'payments2'}}).data("dd");
    }
    $(document).ready(function(e) {		
    //no use
    try {
        var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
            var val = data.value;
            if(val!="")
                window.location = val;
        }}}).data("dd");

        var pagename = document.location.pathname.toString();
        pagename = pagename.split("/");
        pages.setIndexByValue(pagename[pagename.length-1]);
        $("#ver").html(msBeautify.version.msDropdown);
    } catch(e) {
    //console.log(e);	
    }
    $("#ver").html(msBeautify.version.msDropdown);

    //convert
    $(".language_drop").msDropdown({roundedBorder:false});
        createByJson();
        $("#tech").data("dd");
    });
    function showValue(h) {
        console.log(h.name, h.value);
    }
    $("#tech").change(function() {
        console.log("by jquery: ", this.value);
    })
    
    
    $(document).ready(function() {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
        });
    });
    

   $(".verticalCarousel").verticalCarousel({
        currentItem: 1,
        showItems: 4,
    });
    
    
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 9000,
      values: [ 70, 9000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    
    
    
})(jQuery)
        }
    }
}
</script>
