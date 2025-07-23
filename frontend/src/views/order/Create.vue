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
                        <fieldset class="box fieldset position-relative">
                            <label for="address">Адрес</label>
                            <input v-model="address" @input="onInput" @keydown.down.prevent="highlight(1)" @keydown.up.prevent="highlight(-1)" @keydown.enter.prevent="selectHighlighted" type="text" id="address" class="form-control" autocomplete="off" placeholder="Начните вводить адрес…">

                            <!-- Список подсказок -->
                            <ul v-if="suggestions.length" class="list-group position-absolute w-100 mt-1" style="z-index: 1000;">
                                <li v-for="(item, idx) in suggestions" :key="item.data.fias_id" :class="['list-group-item list-group-item-action', { active: idx === highlighted }]" @click="select(item)" @mouseenter="highlighted = idx">
                                    {{ item.value }}
                                </li>
                            </ul>
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
                            <div class="d-flex justify-content-between" :class="{ 'error-highlight': showPriceError }">
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
                                    <router-link :to="{ name: 'terms-conditions' }" :class="['text-decoration-underline', { 'text-error': showPolicyError }]">
                                        политике конфиденциальности
                                    </router-link>.
                                </p>

                                <div class="box-checkbox fieldset-radio mb_20">
                                    <input type="checkbox" id="check-agree" class="tf-check" v-model="agreed" @change="showPolicyError = false" />
                                    <label for="check-agree" class="text_black-2">
                                        Я ознакомлен и согласен с
                                        <router-link :to="{ name: 'terms-conditions' }" :class="['text-decoration-underline', { 'text-error': showPolicyError }]">
                                            условиями и положениями
                                        </router-link> сайта.
                                    </label>
                                </div>
                            </div>

                            <button @click.prevent="storeOrder" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center">
                                Оформить заказ
                            </button>
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

            address: '', // то, что вводит пользователь
            suggestions: [], // массив подсказок
            selected: {
                data: {}
            }, // выбранный адрес
            highlighted: -1, // индекс текущей подсвеченной подсказки
            timer: null,

            card: null,
            isLinkInCard: false,

            agreed: false,
            showPolicyError: false,
            showPriceError: false
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
            axios.get('/sanctum/csrf-cookie', {
                    withCredentials: true
                })
                .then(response => {
                    axios.get('/api/user', {
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

            if (!this.$parent?.$parent?.cardProducts || !this.$parent?.$parent?.cardProducts?.length ) {
                this.showPriceError = true
                setTimeout(() => (this.showPriceError = false), 500)
                return
            }

            if (!this.agreed) {
                this.showPolicyError = true
                setTimeout(() => {
                    this.showPolicyError = false
                }, 500)
                return
            }

            let id = this.user.id
            this.axios.post(`/api/orders/${id}/create`, {
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
                    localStorage.removeItem('cart');

                    this.$router.push({
                        name: 'account.order'
                    });
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

            if (!this.card) return

            this.card.forEach(position => {
                if (position.link_url) {
                    this.isLinkInCard = true
                    return
                }
            });
        },

        onInput() {
            clearTimeout(this.timer);
            if (this.address.length < 3) {
                this.suggestions = [];
                return;
            }
            // debounce 300 мс
            this.timer = setTimeout(this.fetchSuggestions, 300);
        },
        async fetchSuggestions() {
            try {
                const res = await axios.post('/api/dadata/address-suggest', {
                    query: this.address
                });
                this.suggestions = res.data.suggestions;
                this.highlighted = 0;
            } catch (e) {
                console.error('DaData proxy error', e);
                this.suggestions = [];
            }
        },

        highlight(direction) {
            const max = this.suggestions.length;
            let idx = this.highlighted + direction;
            if (idx < 0) idx = max - 1;
            if (idx >= max) idx = 0;
            this.highlighted = idx;
        },
        selectHighlighted() {
            if (this.suggestions[this.highlighted]) {
                this.select(this.suggestions[this.highlighted]);
            }
        },
        select(item) {
            this.address = item.value;
            this.selected = item;
            this.suggestions = [];
        },
    },

}
</script>

<style>
/* Серый фон при наведении */
.list-group-item-action:hover {
    background-color: #f8f9fa;
    /* светло-серый */
    color: #000;
    /* чёрный текст */
}

/* Серый фон для активного элемента */
.list-group-item-action.active,
.list-group-item-action:active,
.list-group-item-action.active:hover,
.list-group-item-action:active:hover {
    background-color: #e9ecef;
    /* средний серый */
    border-color: #e9ecef;
    color: #000;
    /* чёрный текст */
}

.text-error {
    color: red !important;
}

.error-highlight h6 {
    color: red !important;
    transition: color 0.3s ease;
}
</style>
