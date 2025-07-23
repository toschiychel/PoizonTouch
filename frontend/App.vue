<template>
<div>
    <div class="preload-wrapper">
        <!-- RTL -->
        <!-- <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill">RTL</a> -->
        <!-- /RTL  -->
        <!-- preload -->
        <div class="preload preload-container">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>
        <!-- /preload -->
        <div id="wrapper">

            <!-- header -->
            <Header ref="header"></Header>
            <!-- /header -->

            <router-view ref="child"></router-view>

            <!-- footer -->
            <Footer></Footer>
            <!-- /footer -->
        </div>

        <!-- mobileMenu -->

        <!-- <MobileMenu></MobileMenu> -->

        <!-- /mobileMenu -->

        <!-- shoppingCart -->
        <div class="modal fullRight fade modal-shopping-cart" id="shoppingCart">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="header">
                        <div class="title fw-5">Корзина</div>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <div class="wrap">
                        <div class="tf-mini-cart-wrap">
                            <div class="tf-mini-cart-main">
                                <div v-if="cardProducts" class="tf-mini-cart-sroll">
                                    <div v-for="product in cardProducts" class="tf-mini-cart-items">
                                        <div class="tf-mini-cart-item">
                                            <div class="tf-mini-cart-image">
                                                <router-link v-if="product.id" :to="`/products/${product.id}`">
                                                    <img :src="product.preview_image" alt="">
                                                </router-link>
                                                <img v-if="!product.id" style="height: 110px; width: 80px;" src="@/assets/images/products/link-image.jpeg" alt="">
                                            </div>
                                            <div class="tf-mini-cart-info">
                                                <router-link v-if="product.id" class="title link" :to="`/products/${product.id}`">{{ product.title }}</router-link>
                                                <div v-if="!product.id" class="title link">{{ product.title }}</div>
                                                <div class="meta-variant"></div>
                                                <div v-if="product.price" class="price fw-6">{{ product.price}}₽</div>
                                                <div v-if="product.price_cny" class="price fw-6">{{ product.price_cny}}¥</div>
                                                <div v-if="product.weight" class="price fw-6">{{ product.weight}}кг</div>
                                                <div class="tf-mini-cart-btns">
                                                    <div class="wg-quantity small">
                                                        <span @click="decreaseQuantity(product)" class="btn-quantity">-</span>
                                                        <!-- <input type="text" name="number" :value="product.quantity"> -->
                                                        <input type="text" name="number" v-model="product.quantity" />
                                                        <span @click="increaseQuantity(product)" class="btn-quantity">+</span>
                                                    </div>
                                                    <div @click="deleteCardProduct(product.title)" class="tf-mini-cart-remove">Удалить</div>
                                                </div>
                                                <!--  -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-minicart-recommendations">
                                        <div class="tf-minicart-recommendations-heading">
                                            <div class="tf-minicart-recommendations-title">Привезем оригинал — специально для вас</div>
                                            <div class="sw-dots small style-2 cart-slide-pagination"></div>
                                        </div>
                                        <div dir="ltr" class="swiper tf-cart-slide">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="tf-minicart-recommendations-item">
                                                        <div class="tf-minicart-recommendations-item-image pb-3">
                                                            <!-- <a click.prevent="" href="#"> -->
                                                            <img class="me-3" style="width: 80px; height: 80px;" src="@/assets/images/products/link-image.jpeg" alt="">
                                                            <!-- </a> -->
                                                        </div>
                                                        <div class="tf-minicart-recommendations-item-infos flex-grow-1">
                                                            <!-- <a class="title" href="product-detail.html">Loose Fit Sweatshirt</a> -->
                                                            <div class="tf-field style-1 mb_15">
                                                                <input v-model="linkTitle" class="tf-field-input tf-input" placeholder=" " type="text" id="property2" name="last name">
                                                                <label v-if="!linkTitle" class="tf-field-label fw-4 text_black-2" for="property2">Название</label>
                                                            </div>
                                                            <div class="tf-field style-1 mb_15">
                                                                <input v-model="linkUrl" class="tf-field-input tf-input" placeholder=" " type="text" id="property2" name="last name">
                                                                <label v-if="!linkUrl" class="tf-field-label fw-4 text_black-2" for="property2">Ссылка на товар</label>
                                                            </div>
                                                            <div class="tf-field style-1 mb_15">
                                                                <input v-model="linkCnyPrice" class="tf-field-input tf-input" placeholder=" " type="text" id="property2" name="last name">
                                                                <label v-if="!linkCnyPrice" class="tf-field-label fw-4 text_black-2" for="property2">Цена в юанях</label>
                                                            </div>
                                                            <div class="tf-field style-1 mb_15">
                                                                <input v-model="linkWeight" class="tf-field-input tf-input" placeholder=" " type="text" id="property2" name="last name">
                                                                <label v-if="!linkWeight" class="tf-field-label fw-4 text_black-2" for="property2">Ориентировочный вес(кг)</label>
                                                            </div>
                                                            <div class="tf-mini-cart-btns" style="display: flex; align-items: center; gap: 12px;">
                                                                <div class="wg-quantity small">
                                                                    <span @click="linkQuantity = linkQuantity - 1" class="btn-quantity">-</span>
                                                                    <input type="text" name="number" v-model="linkQuantity" />
                                                                    <span @click="linkQuantity = linkQuantity + 1" class="btn-quantity">+</span>
                                                                </div>

                                                                <div @click="addLinkToCard()" class="tf-mini-cart-remove link" style="cursor: pointer;">
                                                                    Добавить
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- <div class="tf-minicart-recommendations-item-quickview pb-5">
                                                            <div class="btn-show-quickview quickview hover-tooltip">
                                                                <span class="icon icon-view"></span>
                                                            </div>
                                                        </div> -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-mini-cart-bottom">
                                <div class="tf-mini-cart-bottom-wrap">
                                    <div class="tf-cart-totals-discounts">
                                        <div class="tf-cart-total">Общая сумма</div>
                                        <div class="tf-totals-total-value fw-6">{{ totalPrice }}.00₽</div>
                                    </div>
                                    <div class="tf-cart-tax">Доставка рассчитываются при модерировании заказа</div>
                                    <div class="tf-mini-cart-line"></div>
                                    <!-- <div class="tf-cart-checkbox">
                                        <div class="tf-checkbox-wrapp">
                                            <input class="" type="checkbox" id="CartDrawer-Form_agree" name="agree_checkbox">
                                            <div>
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <label for="CartDrawer-Form_agree"> Я соглашаюсь с <router-link :to="{name: 'terms-conditions'}" title="Terms of Service">условиями использования</router-link> </label>
                                    </div> -->
                                    <div class="tf-mini-cart-view-checkout">
                                        <!-- <a href="view-cart.html" class="tf-btn btn-outline radius-3 link w-100 justify-content-center">View cart</a> -->
                                        <router-link :to="{ name: 'order.create' }" class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Оформить</span></router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /shoppingCart -->
    </div>
</div>
</template>

<script>
import Footer from '@/views/layouts/Footer.vue';
import Header from '@/views/layouts/Header.vue';
import MobileMenu from '@/views/layouts/MobileMenu.vue';
import axios from 'axios';

export default {
    name: 'App',

    components: {
        Footer,
        Header,
        MobileMenu
    },

    data() {
        return {
            cardProducts: [],
            totalPrice: 0,
            user: [],
            linkUrl: '',
            linkTitle: '',
            linkQuantity: 1,
            linkCnyPrice: null,
            linkWeight: null
        }
    },

    methods: {
        getCardProducts() {
            this.cardProducts = JSON.parse(localStorage.getItem('cart'))

            this.totalPrice = 0
            if (this.cardProducts) {
                this.cardProducts.forEach(product => {
                    let productPrice = parseFloat(product.price) || 0; // Если price не число, присваиваем 0
                    let productQuantity = parseInt(product.quantity) || 0; // Если quantity не число, присваиваем 0

                    let productsPrice = productPrice * productQuantity; // Умножаем цену на количество

                    // Добавляем к общей сумме
                    this.totalPrice += productsPrice;
                });
            }
        },

        addLinkToCard() {
            let cart = localStorage.getItem('cart');

            if (![this.linkTitle, this.linkUrl, this.linkQuantity, this.linkCnyPrice, this.linkWeight].every(v => v)) {
                return;
            }

            try {
                new URL(this.linkUrl);
            } catch (e) {  
                return;
            }

            // 3. Проверка, что weight и price — числа
            let weight = parseFloat(this.linkWeight);
            let price = parseFloat(this.linkCnyPrice);
            if (!Number.isFinite(weight) || !Number.isFinite(price)) {
                return;
            }

            // Формируем новый товар
            let newProduct = {
                'title': this.linkTitle,
                'link_url': this.linkUrl,
                'quantity': this.linkQuantity,
                'price_cny': this.linkCnyPrice,
                'weight': this.linkWeight,
                'type': 'link'
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

                cart.push(newProduct);
                localStorage.setItem('cart', JSON.stringify(cart)); // сохраняем обновленную корзину

                this.linkTitle = ''
                this.linkUrl = ''
                this.linkQuantity = 1
                this.linkCnyPrice = null,
                    this.linkWeight = null

                this.cardProducts = JSON.parse(localStorage.getItem('cart'))
                this.getCardProducts()

            }
        },

        deleteCardProduct(title) {
            let cart = JSON.parse(localStorage.getItem('cart'));

            // Фильтруем товары, удаляя тот, у которого id совпадает с переданным
            cart = cart.filter(product => product.title !== title);

            localStorage.setItem('cart', JSON.stringify(cart));

            this.getCardProducts()
        },

        updateCart() {
            localStorage.setItem('cart', JSON.stringify(this.cardProducts))
            this.getCardProducts()
        },

        increaseQuantity(product) {
            product.quantity++;
            this.updateCart();
        },

        decreaseQuantity(product) {
            if (product.quantity > 1) {
                product.quantity--;
                this.updateCart();
            }
        },

        handleStorageChange(event) {
            if (event.key === 'cart') {
                this.getCardProducts();
            }
        }
    },

    mounted() {
        if (localStorage.getItem('cart')) {
            this.getCardProducts()
        }
        window.addEventListener('storage', this.handleStorageChange);
    },
}
</script>

<style scoped>
.tf-field-label {
    font-size: 12px;
}

.tf-field.style-1 .tf-field-input {
    padding: 6px 12px;
    height: auto;
    font-size: 14px;
}
</style>
