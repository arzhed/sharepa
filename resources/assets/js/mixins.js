
module.exports = {
    mixLogin : function(email,password, redirect = false) {
        var vm = this;
        vm.callbackError = false;

        axios.post('/oauth/token', {
            'grant_type': 'password',
            'client_id': 2,
            'client_secret': 'H1e3Dy4wM6t1MJM4wx87B6ZU8KIbAf1f4ycxfYt6',
            'username' : email,
            'password' : password,
            'scope' : ''
        }).then(function(response) {
            localStorage.setItem('shtoken', response.data.access_token)
            localStorage.setItem('shemail', email)
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;

            vm.$emit('toggle-logged');

            if (redirect)
                vm.$router.push({path: redirect});
        }).catch(function(error) {
            vm.callbackError = true;
        })
    }
}
