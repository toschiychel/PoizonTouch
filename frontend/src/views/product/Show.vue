<template lang="">
<div>
    <div class="preload-wrapper">
        <div class="preload preload-container">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>
        <div class="flat-spacing-4 pt_4 preload-wrapper" v-if="product">
            <div class="tf-main-product">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tf-product-media-wrap sticky-top">
                                <div class="thumbs-slider thumbs-default">
                                    <div dir="ltr" class="swiper tf-product-media-thumbs tf-product-media-thumbs-default" data-direction="vertical">
                                        <div class="swiper-wrapper stagger-wrap">
                                            <div class="swiper-slide stagger-item" data-color="white">
                                                <div class="item">
                                                    <img class="lazyload" :data-src="product.preview_image" :src="product.preview_image" alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="white" v-for="image in product.images">
                                                <div class="item">
                                                    <img class="lazyload" :data-src="image.url" :src="image.url" alt="img-product">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div dir="ltr" class="swiper tf-product-media-main tf-product-media-main-default">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide" data-color="white">
                                                <a @click.prevent="" href="#" class="item">
                                                    <img class="lazyload" :data-src="product.preview_image" :src="product.preview_image" alt="img-product">
                                                </a>
                                            </div>
                                            <div class="swiper-slide" data-color="white" v-for="image in product.images">
                                                <a @click.prevent="" href="#" class="item">
                                                    <img class="lazyload" :data-src="image.url" :src="image.url" alt="img-product">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                        <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-zoom-main"></div>
                                <div class="tf-product-info-list other-image-zoom">
                                    <div class="tf-product-info-title">
                                        <h5>{{ product.title }}</h5>
                                    </div>
                                    <div class="tf-product-info-price">
                                        <div class="price-on-sale text_black">{{ product.price }}₽</div>
                                    </div>
                                    <div class="tf-product-info-variant-picker">
                                        <div class="variant-picker-item">
                                            <div class="variant-picker-label">
                                                Цвет: <span class="fw-6 variant-picker-label-value value-currentColor"></span>
                                            </div>
                                            <div class="variant-picker-values">
                                                <template v-for="color in product.colors">
                                                    <input id="values-white" type="radio" name="color1" checked>
                                                    <label class="hover-tooltip radius-60 color-btn active" data-color="white" for="values-white" data-value="White">
                                                        <span class="btn-checkbox" :style="`background-color: ${color.hex};`"></span>
                                                        <span class="tooltip">{{ color.title }}</span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                        <!-- <div class="variant-picker-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="variant-picker-label">
                                                    Размер: <span class="fw-6 variant-picker-label-value">S</span>
                                                </div>
                                            </div>
                                            <div class="variant-picker-values">
                                                <input type="radio" name="size1" id="values-s" checked>
                                                <label class="style-text size-btn" for="values-s" data-value="S">
                                                    <p>S</p>
                                                </label>
                                                <input type="radio" name="size1" id="values-m">
                                                <label class="style-text size-btn" for="values-m" data-value="M">
                                                    <p>M</p>
                                                </label>
                                                <input type="radio" name="size1" id="values-l">
                                                <label class="style-text size-btn" for="values-l" data-value="L">
                                                    <p>L</p>
                                                </label>
                                                <input type="radio" name="size1" id="values-xl">
                                                <label class="style-text size-btn" for="values-xl" data-value="XL">
                                                    <p>XL</p>
                                                </label>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="tf-product-info-quantity">
                                        <div class="quantity-title fw-6">Количество</div>
                                        <div class="wg-quantity">
                                            <span class="btn-quantity btn-decrease">-</span>
                                            <input type="text" id="product-quantity" class="quantity-product" name="number" value="1" ref="quantityInput" @input="validateQuantity">
                                            <span class="btn-quantity btn-increase">+</span>
                                        </div>

                                    </div>
                                    <div class="tf-product-info-buy-button">
                                        <form class="">
                                            <a @click.prevent="addToCard(product)" href="#" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Добавить в корзину -&nbsp;</span><span class="tf-qty-price total-price">{{ product.price }}₽</span></a>
                                            <!-- <a href="javascript:void(0);" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Добавить в избранное</span>
                                                <span class="icon icon-delete"></span>
                                            </a> -->

                                            <!-- <div class="w-100">
                                                <a href="#" class="btns-full">Купить в один клин <img src="@/assets/images/payments/paypal.png" alt=""></a>
                                            </div> -->
                                        </form>
                                    </div>
                                    <div class="container p-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="widget-tabs style-has-border">
                                                    <ul class="widget-menu-tab">
                                                        <li class="item-title active">
                                                            <span class="inner">Описание</span>
                                                        </li>
                                                    </ul>
                                                    <div class="widget-content-tab">
                                                        <div class="widget-content-inner active">
                                                            <div class="">
                                                                <p class="mb_30">
                                                                    {{ product.content }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="tf-product-info-delivery-return">
                                        <div class="row">
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery">
                                                    <div class="icon">
                                                        <i class="icon-delivery-time"></i>
                                                    </div>
                                                    <p>Ожидаемое время доставки: <span class="fw-7">12-26 дней</span> (международная доставка), <span class="fw-7">3-6 дней</span> (США).</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery mb-0">
                                                    <div class="icon">
                                                        <i class="icon-return-order"></i>
                                                    </div>
                                                    <p>Возврат в течение <span class="fw-7">30 дней</span> с момента покупки. Налоги и сборы не подлежат возврату.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="tf-product-info-extra-link">
                                        <a href="https://t.me/prodbytoschiy" target="_blank" class="tf-product-extra-icon">
                                            <div class="icon">
                                                <i class="icon-question"></i>
                                            </div>
                                            <div class="text fw-6">Задать вопрос</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tf-sticky-btn-atc">
                <div class="container">
                    <div class="tf-height-observer w-100 d-flex align-items-center">
                        <div class="tf-sticky-atc-product d-flex align-items-center">
                            <div class="tf-sticky-atc-img">
                                <img class="lazyloaded" :data-src="product.preview_image" alt="" :src="product.preview_image">
                            </div>
                            <div class="tf-sticky-atc-title fw-5 d-xl-block d-none">{{ product.title}}</div>
                        </div>
                        <div class="tf-sticky-atc-infos">
                            <form class="">
                                <a @click.prevent="addToCard(product)" href="#" class="tf-btn btn-fill radius-3 justify-content-center fw-6 fs-14 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Добавить в корзину</span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return {
            scriptElements: [],
            carousel: null,
            product: null,
        }
    },

    mounted() {

        // add scripts
        const scripts = [
            '../src/assets/js/bootstrap.min.js',
            '../src/assets/js/jquery.min.js',
            '../src/assets/js/swiper-bundle.min.js',
            '../src/assets/js/carousel.js',
            '../src/assets/js/count-down.js',
            '../src/assets/js/bootstrap-select.min.js',
            '../src/assets/js/lazysize.min.js',
            '../src/assets/js/drift.min.js',
            '../src/assets/js/wow.min.js',
            '../src/assets/js/multiple-modal.js',
            '../src/assets/js/main.js'
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
        this.getProduct()

    },

    beforeUnmount() {
        this.scriptElements.forEach(script => {
            document.body.removeChild(script); // Удаляем каждый скрипт из DOM
        });
        this.scriptElements = []; // Очищаем массив
    },

    methods: {
        getProduct() {
            let id = this.$route.params.id

            axios.get(`/api/products/${id}`)
                .then(res => {
                    this.product = res.data.data

                })
        },

        addToCard(product) {
            let cart = localStorage.getItem('cart');
            let quantity = document.getElementById('product-quantity').value;

            // Преобразуем количество в число и проверяем его
            quantity = parseInt(quantity);
            if (isNaN(quantity) || quantity <= 0) {
                console.error('Количество товара должно быть положительным числом');
                return;
            }

            // Формируем новый товар
            let newProduct = {
                'id': product.id,
                'title': product.title,
                'quantity': quantity,
                'price': product.price,
                'preview_image': product.preview_image,
                'type': 'product'
            };

            // Если корзина пуста, добавляем товар
            if (!cart) {
                localStorage.setItem('cart', JSON.stringify([newProduct]));
            } else {
                try {
                    cart = JSON.parse(cart); // пытаемся распарсить данные
                } catch (e) {
                    console.error('Ошибка парсинга JSON:', e);
                    cart = []; // если ошибка парсинга, очищаем cart
                }

                let productExists = false;

                // Проверяем, есть ли товар в корзине
                cart.forEach((productInCart, index) => {
                    if (productInCart.id === product.id) {
                        // Перезаписываем количество товара в корзине
                        cart[index].quantity = quantity;
                        productExists = true;
                    }
                });

                // Если товара нет в корзине, добавляем новый
                if (!productExists) {
                    cart.push(newProduct);
                }

                localStorage.setItem('cart', JSON.stringify(cart)); // сохраняем обновленную корзину

                document.getElementById('product-quantity').value = 1;

                this.$parent.$parent.cardProducts = JSON.parse(localStorage.getItem('cart'))
                this.$parent.$parent.getCardProducts()

            }
        },
    }
}
</script>

<style lang="">
    
</style>
