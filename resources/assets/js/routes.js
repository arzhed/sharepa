var routes = [
    {
        path: '/',
        component: require('./views/Home.vue')
    },
    {
        path: '/login',
        component: require('./views/Login.vue')
    },
    {
        path: '/register',
        component: require('./views/Register.vue')
    },
];

module.exports = new VueRouter({
    routes: routes
});
