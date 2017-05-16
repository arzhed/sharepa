<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends BaseAppController
{
    public function guideSpecificRegistration()
    {
        if ($this->user->isTraveler()) {
            return '/';
        }
        if ($this->user->isRegistrationOver()) {
            return '/';
        }
        return view('auth.guide');
    }
}
