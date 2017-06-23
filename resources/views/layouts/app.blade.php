<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav id="main-nav" class="navbar navbar-default no-margin">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <router-link class="navbar-brand bold" to="/">{{ config('app.name', 'Laravel') }}</router-link>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul v-if="user.role == 'traveler'" class="nav navbar-nav">
                        <li><router-link to="/">Choose your path</router-link></li>
                        <!-- <li><router-link to="#experiences">Best experiences</router-link></li> -->
                    </ul>
                    <ul v-if="user.role == 'guide'" class="nav navbar-nav">
                        <li><router-link to="/guide/dashboard">Dashboard</router-link></li>
                        <li><router-link to="/guide/adventures">Adventures</router-link></li>
                    </ul>
                    <ul v-if="!logged" class="nav navbar-nav navbar-right">
                      <!-- Authentication Links -->
                        <li><router-link to="login">Login</router-link></li>
                        <li><router-link to="register">Register</router-link></li>
                    </ul>

                    <ul v-if="logged" class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                 @{{ user.name }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a v-on:click="switchRole">Switch to
                                        <span v-if="user.role == 'traveler'">Guide</span>
                                        <span v-if="user.role == 'guide'">Traveler</span> mode</a>
                                </li>
                                <li>
                                    <a v-on:click="logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->

            </div><!-- /.container-fluid -->
        </nav>

        <router-view id="main-view" v-on:toggle-logged="toggleLogged" :user="user" :logged="logged"></router-view>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
