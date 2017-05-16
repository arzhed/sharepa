<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseAppController extends Controller
{
    protected $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user= \Auth::user();

            return $next($request);
        });

        $this->middleware('auth');
    }
}
