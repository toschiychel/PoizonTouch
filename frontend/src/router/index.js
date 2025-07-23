import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [

    // main
    {
      path: '/',
      name: 'main',
      component: () => import('../views/main/Index.vue'),
    },

    // products
    {
      path: '/products',
      name: 'product.index',
      component: () => import('../views/product/Index.vue')
    },
    {
      path: '/products/:id',
      name: 'product.show',
      component: () => import('../views/product/Show.vue')
    },

    // account
    {
      path: '/account',
      name: 'account',
      component: () => import('../views/account/Index.vue')
    },
    {
      path: '/account/register',
      name: 'account.register',
      component: () => import('../views/account/Register.vue')
    },
    {
      path: '/account/login',
      name: 'account.login',
      component: () => import('../views/account/Login.vue')
    },
    {
      path: '/account/orders',
      name: 'account.order',
      component: () => import('../views/account/Order.vue')
    },
    {
      path: '/account/edit',
      name: 'account.edit',
      component: () => import('../views/account/Edit.vue')
    },
    
    // order
    {
      path: '/order/create',
      name: 'order.create',
      component: () => import('../views/order/Create.vue')
    },

    // terms conditions
    {
      path: '/terms-conditions',
      name: 'terms-conditions',
      component: () => import('../views/main/TermsConditions.vue')
    },
    


    // 404 error not-found
    // redirect to main page
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/main/Index.vue'),
    },
  ],
})

router.afterEach(() => {
  nextTick(() => {
    // Удаляем лишние backdrop'ы
    document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());

    // Удаляем классы show, если забыли
    document.querySelector('.sidebar-filter')?.classList.remove('show');
    document.querySelector('.overlay-filter')?.classList.remove('show');
    document.body.classList.remove('offcanvas-backdrop', 'show', 'modal-open');
  });
});

export default router
