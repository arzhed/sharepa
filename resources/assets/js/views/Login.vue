<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" v-on:submit="submit">
                            <span class="form-error" v-show="callbackError">Wrong email or password</span>
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input type="email" id="email" v-model.trim="email" class="form-control" name="email" autofocus=""></input>
                                    <span class="form-error" v-show="!$v.email.required">Email is required</span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" id="password" v-model.trim="password" class="form-control" name="password"></input>
                                    <span class="form-error" v-show="!$v.password.required">Password is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" v-on:click="login">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data : function () {
            return {
                email : '',
                password : '',
                callbackError : false
            }
        },
        validations : {
            email: {
                required: Validator.required
            },
            password: {
                required: Validator.required
            }
        },
        methods : {
            submit: function(e) {
                e.preventDefault();
            },
            login : function() {
                var vm = this;
                vm.callbackError = false;
                axios.post('/oauth/token', {
            		'grant_type': 'password',
            		'client_id': 2,
            		'client_secret': 'H1e3Dy4wM6t1MJM4wx87B6ZU8KIbAf1f4ycxfYt6',
            		'username' : this.email,
                    'password' : this.password,
                    'scope' : ''
                }).then(function(response) {
                    console.log('response', response)

                    vm.$router.push({path: '/'});
                }).catch(function(error) {
                    console.log(error)
                    console.log(vm)
                    vm.callbackError = true;
                })
            }
        }
    }
</script>
