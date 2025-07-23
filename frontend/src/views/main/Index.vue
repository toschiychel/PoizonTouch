<template lang="">
<div>
    <div class="preload-wrapper">
        <div class="preload preload-container">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>

        <!-- slider -->
        <div class="tf-slideshow slider-women slider-effect-fade position-relative">
            <div dir="ltr" class="swiper tf-sw-slideshow" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-loop="true" data-auto-play="false" data-delay="2000" data-speed="1000">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" lazy="true">
                        <div class="wrap-slider">
                            <img class="lazyload" data-src="/src/assets/images/slider/main_slider_1.png" src="/src/assets/images/slider/main_slider_1.png" alt="women-slideshow-01">
                            <div class="box-content">
                                <div class="container">
                                    <h1 class="fade-item fade-item-1">Poizon. Без границ</h1>
                                    <p class="fade-item fade-item-2">Доставка любых товаров — напрямую к тебе</p>
                                    <a href="#shoppingCart" data-bs-toggle="modal" class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-60"><span>Заказать</span><i class="icon icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" lazy="true">
                        <div class="wrap-slider">
                            <img class="lazyload" data-src="/src/assets/images/slider/main_slider_2.png" src="/src/assets/images/slider/main_slider_2.png" alt="women-slideshow-02">
                            <div class="box-content">
                                <div class="container">
                                    <h1 class="fade-item fade-item-1">Оригинал. Только лучше</h1>
                                    <p class="fade-item fade-item-2">Лучшие бренды по честной цене из Китая</p>
                                    <a href="#shoppingCart" data-bs-toggle="modal" class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-60"><span>Заказать</span><i class="icon icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" lazy="true">
                        <div class="wrap-slider">
                            <img class="lazyload" data-src="/src/assets/images/slider/main_slider_3.png" src="/src/assets/images/slider/main_slider_3.png" alt="women-slideshow-03">
                            <div class="box-content">
                                <div class="container">
                                    <h1 class="fade-item fade-item-1">Весь мир — в твоей корзине</h1>
                                    <p class="fade-item fade-item-2">Мировые бренды. Лучшая доставка. Уникальные предложения</p>
                                    <a href="#shoppingCart" data-bs-toggle="modal" class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-60"><span>Заказать</span><i class="icon icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-pagination">
                <div class="container">
                    <div class="sw-dots sw-pagination-slider justify-content-center"></div>
                </div>
            </div>
        </div>
        <!-- /slider -->

        <!-- <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Магазин</div>
            </div>
        </div> -->
        <!-- Categories -->
        <section class="flat-spacing-5 pb_0">
            <div class="container">
                <div class="flat-title">
                    <span class="title wow fadeInUp" data-wow-delay="0s">Открой для себя коллекции</span>
                </div>
                <div class="hover-sw-nav">
                    <div dir="ltr" class="swiper tf-sw-collection" data-preview="4" data-tablet="2" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                        <div class="swiper-wrapper">
                            <div v-for="category in categories" class="swiper-slide" lazy="true">
                                <div class="collection-item style-2 hover-img">
                                    <div class="collection-inner">
                                        <router-link to="/products" class="collection-image img-style">
                                            <img class="lazyload" :data-src="category.smallPreviewImage" :src="category.smallPreviewImage" alt="collection-img2" width="360" height="430">
                                        </router-link>
                                        <div class="collection-content">
                                            <router-link to="/products" class="tf-btn collection-title hover-icon fs-15 rounded-full"><span>{{ category.title }}</span><i class="icon icon-arrow1-top-left"></i></router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-sw nav-next-slider nav-next-collection box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
                    <div class="nav-sw nav-prev-slider nav-prev-collection box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
                    <div class="sw-dots style-2 sw-pagination-collection justify-content-center"></div>
                </div>
            </div>
        </section>
        <!-- /Categories -->

        <!-- Banner Collection -->
        <section class="flat-spacing-10 pb_0">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-recent" data-preview="2" data-tablet="2" data-mobile="1.3" data-space-lg="30" data-space-md="15" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div v-for="category in bigCategory" class="swiper-slide" lazy="true">
                            <div class="collection-item-v4 hover-img">
                                <div class="collection-inner">
                                    <router-link to="/products" class="collection-image img-style radius-10">
                                        <img class="lazyload" :data-src="category.bigPreviewImage" :src="category.bigPreviewImage" alt="collection-img">
                                    </router-link>
                                    <div class="collection-content wow fadeInUp" data-wow-delay="0s">
                                        <h5 class="heading text_white">{{ category.title }}</h5>
                                        <router-link to="/products" class="tf-btn style-3 fw-6 btn-light-icon rounded-full animate-hover-btn"><span>Открыть</span></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner Collection -->

        <!-- Best seller -->
        <section class="flat-spacing-15 pb_0 mb-5">
            <div class="container">
                <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                    <span class="title">Что берут прямо сейчас</span>
                    <p class="sub-title">Хиты продаж</p>
                </div>
                <div class="hover-sw-nav hover-sw-3">
                    <div dir="ltr" class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                        <div class="swiper-wrapper">
                            <div v-for="product in products" class="swiper-slide" lazy="true">
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <router-link :to="`/products/${product.id}`" class="product-img">
                                            <img class="lazyload img-product" :data-src="product.preview_image" :src="product.preview_image" alt="image-product">
                                            <img class="lazyload img-hover" :data-src="product.preview_image" :src="product.preview_image" alt="image-product">
                                        </router-link>
                                    </div>
                                    <div class="card-product-info">
                                        <router-link :to="`/products/${product.id}`" class="title link">{{ product.title }}</router-link>
                                        <span class="price">{{ product.price }}₽</span>
                                        <ul class="list-color-product">
                                            <li v-for="color in product.colors" class="list-color-item color-swatch active">
                                                <span class="tooltip">{{ color.title }}</span>
                                                <span class="swatch-value" :style="`background-color: ${color.hex} ;`"></span>
                                                <img class="lazyload" :data-src="product.preview_image" :src="product.preview_image" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
                    <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
                </div>
            </div>
        </section>
        <!-- /Best seller -->
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Index",

    data() {
        return {
            scriptElements: [], // Массив для хранения загруженных скриптов

            products: null,
            categories: null,
            bigCategory: null,
        };
    },

    mounted() {
        this.getProduct();

        // add scripts
        const scripts = [
            'src/assets/js/jquery.min.js',
            'src/assets/js/bootstrap.min.js',
            'src/assets/js/swiper-bundle.min.js',
            'src/assets/js/carousel.js',
            'src/assets/js/bootstrap-select.min.js',
            'src/assets/js/lazysize.min.js',
            'src/assets/js/count-down.js',
            'src/assets/js/wow.min.js',
            'src/assets/js/multiple-modal.js',
            'src/assets/js/main.js'
        ];

        const loadScript = (src) => {
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = src;
                script.async = true;

                script.onload = () => {
                    this.scriptElements.push(script); // Сохраняем ссылку на скрипт
                    resolve();
                };
                script.onerror = () => reject(new Error(`Ошибка загрузки скрипта: ${src}`));

                document.body.appendChild(script);
            });
        };

        const loadScriptsSequentially = async () => {
            for (const src of scripts) {
                try {
                    await loadScript(src);
                } catch (error) {
                    console.error(error);
                }
            }
        };

        loadScriptsSequentially();

    },

    beforeUnmount() {
        this.scriptElements.forEach(script => {
            document.body.removeChild(script); // Удаляем каждый скрипт из DOM
        });
        this.scriptElements = []; // Очищаем массив

        this.products = null
        this.categories = null
        this.bigCategory = null
    },

    methods: {
        getProduct() {
            axios.get('/api/main')
                .then(res => {
                    this.products = res.data.products
                    this.categories = res.data.categories
                    this.bigCategory = res.data.bigCategories

                })
        }
    }
}
</script>

<style lang="">
    
</style>
