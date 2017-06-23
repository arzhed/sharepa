<template>
    <div>
        <div class="padding-top-45">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Register</div>
                        <div class="panel-body">
                            <form class="form-horizontal" v-on:submit="submit">
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input type="name" v-on:input="$v.name.$touch" id="name" v-model.trim="name" class="form-control" name="name" autofocus=""></input>
                                        <span class="form-error" v-show="$v.name.$dirty && !$v.name.required">Username is required</span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">Email</label>

                                    <div class="col-md-6">
                                        <input type="email" v-on:input="$v.email.$touch" id="email" v-model.trim="email" class="form-control" name="email" autofocus=""></input>
                                        <span class="form-error" v-show="$v.email.$dirty && !$v.email.required">Email is required</span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input type="password" v-on:input="$v.password.$touch" id="password" v-model.trim="password" class="form-control" name="password"></input>
                                        <span class="form-error" v-show="$v.password.$dirty && !$v.password.required">Password is required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm" class="col-md-4 control-label">Confirm password</label>

                                    <div class="col-md-6">
                                        <input type="password" v-on:input="$v.confirm.$touch" id="confirm" v-model.trim="confirm" class="form-control" name="confirm"></input>
                                        <span class="form-error" v-show="$v.confirm.$dirty && !$v.confirm.required">Confirm is required</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="col-md-4 control-label">What do you want to be?</label>

                                    <div class="col-md-6">
                                        <label>
                                            <input type="radio" name="role" id="traveler" value="traveler" checked v-model="role"> Traveler
                                        </label>
                                        <label class="margin-left-5">
                                            <input type="radio" name="role" id="guide" value="guide" v-model="role"> Guide
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary" v-on:click="submit">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                name          : '',
                email         : '',
                password      : '',
                confirm       : '',
                role          : 'traveler',
                callbackError : false
            }
        },
        validations : {
            name: {
                required: Validator.required
            },
            email: {
                required: Validator.required
            },
            password: {
                required: Validator.required
            },
            confirm: {
                required: Validator.required
            },
            role: {
                required: Validator.required
            },
        },
        methods : {
            submit: function(e) {
                e.preventDefault();
                this.callbackError = false;
                var vm = this;

                axios.post('/api/user', {
                	'name'                   : vm.name,
                	'email'                  : vm.email,
                    'password'               : vm.password,
                    'password_confirmation'  : vm.confirm,
                	'role'                   : vm.role,
                }).then(function(response) {
                    var redirect = '/register/2';
                    mixin.mixLogin.call(vm, vm.email, vm.password, redirect);
                }).catch(function(error) {
                    vm.callbackError = true;
                })
            },
        }
    }
</script>
