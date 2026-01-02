<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\MasterUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AllowSyncCBS
{
    use MasterUser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** check if current user is master */
        if ($this->isMasterUser()) {
            return $next($request);
        }

        /** make sure we already hase master account */
        $this->generateMasterUser();

        /** check authorize */
        $user = User::firstWhere('email', "{$request->username}@princebank.com.kh");
        if (!$user) {
            return response(['reposnseCode'=>'401','data'=>'Unauthorized'], 200);
        }

        /** check is the same password */
        if (!Hash::check($request->password, $user->password)) {
            return response(['reposnseCode'=>'401','data'=>'Unauthorized'], 200);
        }
        return $next($request);
    }

    private function generateMasterUser()
    {
        $setting    = config('setting');
        $masterUser = (object)$setting['master_user'];

        /**find if user exist */
        $user = User::firstWhere('email', $masterUser->email);
        if ($user) {
            $user->update([
                'name'     => $masterUser->name,
                'email'    => $masterUser->email,
                'password' => bcrypt($masterUser->password),
                'role_id'  => '0'
            ]);
            return $user;
        }

        $user = User::create([
            'name'     => $masterUser->name,
            'email'    => $masterUser->email,
            'password' => bcrypt($masterUser->password),
            'role_id'  => '0'
        ]);
        return $user;
    }
}
