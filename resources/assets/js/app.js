
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue');

 window.CONFIG = require('./config.js');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router'
window.VueRouter = VueRouter;
Vue.use(VueRouter)

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
window.Validator = require('vuelidate/lib/validators');

var routes = require('./routes.js');


const app = new Vue({
    el: '#app',
    router: routes,
    mounted : function () {
        this.getUserByMail()
    },
    data : function() {
        return {
            logged : false,
            user   : { name : ''}
        }
    },
    methods : {
        toggleLogged : function() {
            this.logged = !this.logged;
            this.getUserByMail();
        },
        getUserByMail : function() {
            if (localStorage.shtoken != null && localStorage.shemail != null) {
                var vm = this;
                axios.post('/api/user/getByMail', {
                    email : localStorage.shemail
                }).then(function(response) {
                    vm.user = response.data;
                    vm.logged = true;
                    localStorage.setItem('shid', response.data.id);
                    localStorage.setItem('shname', response.data.name);
                });
            }
        }
    }
});
