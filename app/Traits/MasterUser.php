<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait MasterUser
{
    public function isMasterUser()
    {
        $setting    = config('setting');
        $masterUser = (object)$setting['master_user'];
        $currentUser= Auth::user();
        return $masterUser->email == $currentUser->email;
    }
}
