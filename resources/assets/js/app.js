
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
Vue.use(Vuelidate);
window.Validator = require('vuelidate/lib/validators');

var routes = require('./routes.js');

var mixins = require('./mixins.js');
window.mixin = mixins;


const app = new Vue({
    el: '#app',
    router: routes,
    mounted : function () {
        this.handleLoginStatus()
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
            this.handleLoginStatus();
        },
        handleLoginStatus : function() {
            var vm = this;
            if (localStorage.shtoken != null && localStorage.shemail != null) {
                axios.post('/api/user/getByMail', {
                    email : localStorage.shemail
                }).then(function(response) {
                    vm.user = response.data;
                    vm.logged = true;
                    localStorage.setItem('shid', response.data.id);
                    localStorage.setItem('shname', response.data.name);
                }).catch(function(error) {
                    vm.logout();
                });
            } else {
                vm.logout()
            }
        },
        logout : function () {
            localStorage.removeItem('shid');
            localStorage.removeItem('shemail');
            localStorage.removeItem('shname');
            localStorage.removeItem('shtoken');
            this.logged = false;
            this.user = { name : ''}
            window.axios.defaults.headers.common['Authorization'] = '';
        }
    }
});
