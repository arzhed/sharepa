function isLoggedIn () {
    return localStorage.getItem('shtoken') != null;
}

var routes = [
    {
        path: '/',
        component: require('./views/Home.vue')
    },
    {
        path: '/login',
        component: require('./views/auth/Login.vue')
    },
    {
        path: '/register',
        component: require('./views/auth/Register.vue'),
        name : 'register',
        beforeEnter : function(to,from,next) {
            if (isLoggedIn()) {
                next(false);
            } else {
                next()
            }
        }
    },
    {
        path: '/register/guide',
        component: require('./views/auth/GuideRegister.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn() && from.name == 'register') {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: '/register/traveler',
        component: require('./views/auth/TravelerRegister.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn() && from.name == 'register') {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: '/guide/adventures',
        component: require('./views/guides/Adventures.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn()) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: '/guide/adventures/create',
        component: require('./views/guides/EditAdventure.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn()) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: '/guide/adventure/:id',
        component: require('./views/guides/EditAdventure.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn()) {
                next();
            } else {
                next(false);
            }
        },
    },
    {
        path: '/traveler/adventure/:id',
        component: require('./views/travelers/ReadAdventure.vue'),
        beforeEnter: function(to,from, next) {
            if (isLoggedIn()) {
                next();
            } else {
                next(false);
            }
        },
    },
];

module.exports = new VueRouter({
    routes: routes,
    // mode: 'history',
    // scrollBehavior : function(to, from, savedPosition) {
    //     if (to.hash) {
    //         return {
    //           selector: to.hash
    //           // , offset: { x: 0, y: 10 }
    //         }
    //     }
    // }
});
