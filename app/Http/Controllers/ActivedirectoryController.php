<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ActivedirectoryController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        /** register master user */
        $this->registerMasterUser();

        /** check env for login */
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'SIT') {
            if (\Auth::attempt(['email' => "{$request->email}@princebank.com.kh", 'password' => $request->password])) {
				$request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                return redirect()->back();
            }
        }

        /** check if you are the master user, then log in with local database */
        $setting    = config('setting');
        $masterUser = (object)$setting['master_user'];
        if ($masterUser->name == $request->email) {
            if (\Auth::attempt(['email' => "{$request->email}@princebank.com.kh", 'password' => $request->password])) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back();
            }
        }

        $username = $request->email;
		$password = $request->password;
		// $server = '10.80.80.113';
		// $domain = '@usct.local';
		$server = '192.168.1.65';
		$domain = '@princeplc.com.kh';
		$port       = 389;

		$ldap_connection = ldap_connect($server, $port);

		if (!$ldap_connection) {
			return redirect()->back()->withErrors(['msg', 'Connectioin Fail']);
		}
		$ldap_dn = "DC=usct,DC=local";
		$ldap_dn = "DC=princeplc,DC=com,DC=kh";
		// Help talking to AD
		ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

		$ldap_bind = @ldap_bind($ldap_connection, $username . $domain, $password);

		if (!$ldap_bind) {
			return redirect()->back()->withErrors(['msg', 'Fail to login']);
		}

		if ($ldap_bind = @ldap_bind($ldap_connection, $username . $domain, $password)) {
			$search_filter = '(&(objectCategory=person)(samaccountname=*)(objectCategory=user)(!(userAccountControl=514))' . "(sAMAccountName=" . $username . ")" . ')';
			$attributes = array();
			$attributes[] = 'givenname';
			$attributes[] = 'mail';
			$attributes[] = 'samaccountname';
			$attributes[] = 'sn';
			$attributes[] = 'title';
			$attributes[] = 'department';
			$attributes[] = 'dn';
			$attributes[] = 'company';
			$attributes[] = 'mobile';

			$result = ldap_search($ldap_connection, $ldap_dn, $search_filter, $attributes) or exit("Unable to search LDAP server");

			$entries = ldap_get_entries($ldap_connection, $result);
			for ($x = 0; $x < $entries['count']; $x++) {
				if (
					!empty($entries[$x]['givenname'][0]) &&
					!empty($entries[$x]['mail'][0]) &&
					!empty($entries[$x]['samaccountname'][0]) &&
					'Shop' !== $entries[$x]['sn'][0] &&
					'Account' !== $entries[$x]['sn'][0]
				) {

					$ad_users[] = array(
						'login_name' => strtoupper(trim($entries[$x]['samaccountname'][0])),
						'email' => strtolower(trim($entries[$x]['mail'][0])),
						'first_name' => trim($entries[$x]['givenname'][0]),
						'last_name' => trim($entries[$x]['sn'][0]),
						'department_name' => trim($entries[$x]['department'][0]),
						'position' => trim($entries[$x]['title'][0]),
					);
				}
			}
			$email = $ad_users[0]['email'];
			if (\Auth::attempt(['email' => $email, 'password' => 'Hello@123'])) {
				return redirect()->route('dashboard');
			} else {
				return redirect()->back();
			}
		}
		ldap_unbind($ldap_connection);
    }

    private function registerMasterUser()
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
