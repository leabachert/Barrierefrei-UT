import { createRouter, createWebHistory } from 'vue-router';
import GebaeudeListe from '../components/GebaeudeListe.vue';
import GebaeudeDetails from '../components/GebaeudeDetails.vue';
import Login from '../components/Login.vue'
import AdminDashboard from '../admin/AdminDashboard.vue'
import { auth } from '../auth';
import AdminGebaeude from '../admin/AdminGebaeude.vue'

const routes = [
    { path: '/', redirect: '/gebaeude' },
    { path: '/gebaeude', component: GebaeudeListe },
    { path: '/gebaeude/:id', component: GebaeudeDetails, props: true },
    { path: '/login', component: Login },
    { path: '/admin', component: AdminDashboard,
        meta: { requiresAuth: true, roles: ['editor','admin'] }
    },
    { path: '/admin/gebaeude/:id', component: AdminGebaeude,
        meta: { requiresAuth: true, roles: ['editor','admin'] }
    }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.meta.requiresAuth

    if (requiresAuth && !auth.isLoggedIn()) {
        next({ path: '/login' })
    } else {
        next()
    }
});
export default router;
