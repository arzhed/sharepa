var routes = [
    {
        path: '/',
        component: require('./views/Home.vue')
    },
    {
        path: '/login',
        component: require('./views/Login.vue')
    },
];

module.exports = new VueRouter({
    routes: routes
});
