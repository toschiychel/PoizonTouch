<template lang="">
<div>
    <section class="flat-spacing-11">
        <div class="container">
            <div class="tf-page-cart-wrap layout-2">
                <div v-if="user" class="tf-page-cart-item">
                    <h5 class="fw-5 mb_20">Платёжные данные</h5>
                    <form class="form-checkout">
                        <div class="box grid-2">
                            <fieldset class="fieldset">
                                <label for="first-name">Имя</label>
                                <input v-model="first_name" type="text" id="first-name">
                            </fieldset>
                            <fieldset class="fieldset">
                                <label for="last-name">Фамилия</label>
                                <input v-model="last_name" type="text" id="last-name">
                            </fieldset>
                        </div>
                        <fieldset class="box fieldset">
                            <label for="address">Адрес</label>
                            <input v-model="address" type="text" id="address">
                        </fieldset>
                        <fieldset class="box fieldset">
                            <label for="phone">Номер телефона</label>
                            <input v-model="phone" type="text" id="phone">
                        </fieldset>
                        <fieldset class="box fieldset">
                            <label for="email">Электронная почта</label>
                            <input v-model="email" type="email" id="email">
                        </fieldset>
                        <fieldset class="box fieldset">
                            <label for="note">Примечание к заказу (необязательно)</label>
                            <textarea v-model="note" name="note" id="note"></textarea>
                        </fieldset>
                    </form>
                </div>

                <div class="tf-page-cart-footer">
                    <div class="tf-cart-footer-inner">
                        <h5 class="fw-5 mb_20">Ваш заказ</h5>
                        <form class="tf-page-cart-checkout widget-wrap-checkout">
                            <ul class="wrap-checkout-product">
                                <li v-for="item in this.$parent.$parent.cardProducts" class="checkout-product-item">
                                    <figure class="img-product">
                                        <img v-if="item.id" :src="item.preview_image" alt="product">
                                        <img v-if="!item.id" src="@/assets/images/products/link-image.jpeg" alt="product">
                                        <span class="quantity">{{ item.quantity }}</span>
                                    </figure>
                                    <div class="content">
                                        <div class="info">
                                            <p class="name">{{ item.title }}</p>
                                            <!-- <span class="variant">Brown / M</span> -->
                                        </div>
                                        <span v-if="item.price" class="price">{{ item.price}}₽</span> 
                                        <span v-if="item.price_cny" class="price">{{ item.price_cny}}¥</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-5">Общая сумма</h6>
                                <h6 v-if="isLinkInCard" class="total fw-5">{{ this.$parent.$parent.totalPrice }} + X₽</h6>
                                <h6 v-if="!isLinkInCard" class="total fw-5">{{ this.$parent.$parent.totalPrice }}₽</h6>
                            </div>
                                                        <div class="d-flex justify-content-between line pb_20">
                                <h8 v-if="isLinkInCard" class="fw-5">Это ориентировочная цена исходя из Ваших товаров. Цена зависит от веса и курса на момент прохождения модерации. Точная цена появится, после сверки модерацией Вашего заказа.</h8>
                            </div>
                            <div class="wd-check-payment">
                                <p class="text_black-2 mb_20">
                                    Ваши персональные данные будут использоваться для обработки вашего заказа, поддержки вашего взаимодействия с сайтом и других целей, описанных в нашей
                                    <a href="privacy-policy.html" class="text-decoration-underline">политике конфиденциальности</a>.
                                </p>
                                <div class="box-checkbox fieldset-radio mb_20">
                                    <input type="checkbox" id="check-agree" class="tf-check">
                                    <label for="check-agree" class="text_black-2">
                                        Я ознакомлен и согласен с
                                        <a href="terms-conditions.html" class="text-decoration-underline">условиями и положениями</a> сайта.
                                    </label>
                                </div>
                            </div>

                            <button @click.prevent="storeOrder()" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center">Оформить заказ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Index",

    data() {
        return {
            scriptElements: [], // Массив для хранения загруженных скриптов

            user: null,
            first_name: '',
            last_name: '',
            phone: '',
            address: '',
            email: '',
            note: '',

            card: null,
            isLinkInCard: false
        };
    },

    mounted() {
        // add scripts
        const scripts = [
            '../src/assets/js/bootstrap.min.js',
            '../src/assets/js/jquery.min.js',
            '../src/assets/js/swiper-bundle.min.js',
            '../src/assets/js/carousel.js',
            '../src/assets/js/bootstrap-select.min.js',
            '../src/assets/js/lazysize.min.js',
            '../src/assets/js/count-down.js',
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
                    console.log(`${src} загружен и выполнен`);
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

        this.getUser();
        this.checkLinkInCard();
    },

    beforeUnmount() {
        this.scriptElements.forEach(script => {
            document.body.removeChild(script); // Удаляем каждый скрипт из DOM
        });
        this.scriptElements = []; // Очищаем массив
    },

    methods: {
        getUser() {
            const xsrfToken = this.getCookieValue('XSRF-TOKEN');
            axios.get('http://localhost:8876/sanctum/csrf-cookie', {
                    withCredentials: true
                })
                .then(response => {
                    axios.get('http://localhost:8876/api/user', {
                            withCredentials: true,
                            headers: {
                                'X-XSRF-TOKEN': decodeURIComponent(xsrfToken)
                            }
                        })
                        .then(res => {
                            this.user = res.data;
                            this.getContactInfo();

                        })
                        .catch(err => {
                            this.$router.push({
                                name: 'account.login'
                            })
                        });
                })
        },

        storeOrder() {
            let id = this.user.id
            this.axios.post(`http://localhost:8876/api/orders/${id}/create`, {
                    'products': this.$parent.$parent.cardProducts,
                    'first_name': this.first_name,
                    'last_name': this.last_name,
                    'address': this.address,
                    'email': this.email,
                    'phone': this.phone,
                    'note': this.note,
                    'total_price': this.$parent.$parent.totalPrice,
                })
                .then(res => {
                    console.log(res);

                    // localStorage.removeItem('cart');
                    
                    // this.$router.push({ name: 'account.order' });
                })

        },

        getContactInfo() {
            this.first_name = this.user.name
            this.last_name = this.user.surname
            this.phone = this.user.phone
            this.address = this.user.address
            this.email = this.user.email
        },

        getCookieValue(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        },

        checkLinkInCard() {
            this.card = JSON.parse(localStorage.getItem('cart'))

            this.card.forEach(position => {
                if (position.link_url) {
                    this.isLinkInCard = true
                    return 
                }
            });
        }
    }
}
</script>
