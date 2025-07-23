<template lang="">
<div>
    <div class="preload-wrapper">
        <div class="preload preload-container">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>
        <!-- <div class="tf-page-title">
                <div class="container-full">
                    <div class="heading text-center">My Account</div>
                </div>
            </div> -->
        <!-- /page-title -->
        <section class="flat-spacing-10">
            <div class="container">
                <div class="form-register-wrap">
                    <div class="flat-title align-items-start gap-0 mb_30 px-0">
                        <h5 class="mb_18">Регистрация</h5>
                        <p class="text_black-2">Подпишитесь, чтобы получить ранний доступ к распродаже, а также персональные новинки, тренды и акции.
                            Чтобы отказаться от рассылки — нажмите «отписаться» в наших письмах.</p>
                    </div>
                    <div>
                        <form class="" id="register-form" action="#" method="post" accept-charset="utf-8" data-mailchimp="true">
                            <div class="tf-field style-1 mb_15">
                                <input v-model="name" class="tf-field-input tf-input" placeholder=" " type="text" id="property1" name="first name">
                                <label class="tf-field-label fw-4 text_black-2" for="property1">Имя *</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input v-model="email" class="tf-field-input tf-input" placeholder=" " type="email" id="property3" name="email">
                                <label class="tf-field-label fw-4 text_black-2" for="property3">Почта *</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input v-model="password" class="tf-field-input tf-input" placeholder=" " type="password" id="property4" name="password">
                                <label class="tf-field-label fw-4 text_black-2" for="property4">Пароль *</label>
                            </div>
                            <div class="tf-field style-1 mb_30">
                                <input v-model="password_confirmation" class="tf-field-input tf-input" placeholder=" " type="password" id="property4" name="password">
                                <label class="tf-field-label fw-4 text_black-2" for="property4">Подтвердите ароль *</label>
                            </div>
                            <div class="mb_20">
                                <button @click.prevent="register()" type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Регистрация</button>
                            </div>
                            <div class="text-center">
                                <router-link to="/account/login" class="tf-btn btn-line">Уже есть аккаунт? Войти<i class="icon icon-arrow1-top-left"></i></router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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

            name: '',
            email: '',
            password: '',
            password_confirmation: '',
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
    },

    beforeUnmount() {
        this.scriptElements.forEach(script => {
            document.body.removeChild(script); // Удаляем каждый скрипт из DOM
        });
        this.scriptElements = []; // Очищаем массив
    },

    methods: {
        register() {
            const xsrfToken = this.getCookieValue('XSRF-TOKEN');

            axios.get('/sanctum/csrf-cookie', {
                    withCredentials: true
                })
                .then(response => {
                    axios.post('/api/register', {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        }, {
                            withCredentials: true,
                            headers: {
                                'X-XSRF-TOKEN': decodeURIComponent(xsrfToken)
                            }
                        })
                        .then(res => {
                            localStorage.setItem('authenticated', true)
                            this.$router.push({ path: '/account' });
                        })
                })
        },

        getCookieValue(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    }
}
</script>
