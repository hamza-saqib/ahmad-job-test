import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/pages/HomeComponent.vue';
import Login from './components/pages/LoginComponent.vue';
import Register from './components/pages/RegisterComponent.vue';
import About from './components/pages/AboutComponent.vue';
import Dashboard from './components/pages/DashboardComponent.vue';
import Company from './components/pages/CompanyComponent.vue';
import Employee from './components/pages/EmployeeComponent.vue';
import LandingPage from './components/pages/LandingPageComponent.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'Landing Page',
            component: LandingPage
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/register',
            name: 'Register',
            component: Register
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            component: Dashboard
        },
        {
            path: '/company',
            name: 'Company',
            component: Company
        },
        {
            path: '/employee',
            name: 'Employee',
            component: Employee
        },
    ]
});

export default router;