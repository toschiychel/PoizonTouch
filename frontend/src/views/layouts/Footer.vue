<template lang="">
<div>
    <footer id="footer" class="footer">
    <div class="footer-wrap">
        <div class="footer-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="footer-logo mb-3">
                            <router-link :to="{name: 'main'}">
                                <img src="@/assets/images/logo/poizon-logo.png" alt="Poizon">
                            </router-link>
                        </div>
                        <ul class="list-unstyled mb-3">
                            <li><p>Email: <a href="mailto:info@toschiy.com">toschiychel@yandex.ru</a></p></li>
                            <li><p>Телефон: <a href="tel:+71234567890">+7 (924) 223-08-90</a></p></li>
                        </ul>
                        <ul class="list-inline mb-3">
                            <li class="list-inline-item"><router-link :to="{name: 'terms-conditions'}">Политика конфиденциальности</router-link></li>
                            <li class="list-inline-item"><router-link :to="{name: 'terms-conditions'}">Условия</router-link></li>
                        </ul>
                        <div class="footer-menu_item small text-muted">
                            © 2025 Poizon Touch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>
</template>

<script>
export default {
    name: "Footer",
}
</script>

<style lang="">
    
</style>
