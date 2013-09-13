<?php

class LoginController extends BaseController {

	public function __construct () 
	{
		//parent::__construct();

		$this->beforeFilter(function()
        {
            if (//App::environment() == 'production' &&
            	Session::has('user')) 
            {
            	return Redirect::to('/');
            }
        });
        
	}

	/**
	 * Handle form input
	 *
	 * @return View or Redirect
	 */
	public function postVine ()
	{
		// from form
		$username = Input::get('username');
		$password = Input::get('password');

		$v = new Vine();
		$keys = $v->login($username, $password);

		if ($keys)
		{
			// get user data
			$v->set_session($keys['key']);
			$user = $v->user($keys['userId']);
			
			// parse info
			$vine_session_id = $keys['key'];
			$id        = $keys['userId'];

			$email     = $user['email'];
			$followers = $user['followerCount'];
			$avatar    = $user['avatarUrl'];
			$username  = $user['username'];
			$twitter   = $user['twitterId'];

			// db
			$db_user = User::find($id);

			if ($db_user) {
				$db_user->vine_session_id = $vine_session_id;
				$db_user->email     = $email;
				$db_user->followers = $followers;
				$db_user->avatar    = $avatar;
				$db_user->username  = $username;
				$db_user->twitter   = $twitter;
				$db_user->save();
			} 
			else
			{
				$user = User::create(compact('id', 'vine_session_id', 'email', 'followers', 
					                         'avatar', 'username', 'twitter'));
			}

			// session
			Session::put('user', $id);
		}
		else
		{
			// generate message
			$list = array(
				'oei, probeer opnieuw',
				'oyoyeah, da was ni juust precies',
				'misschien was het een ander wachtwoord',
				'misschien was het een ander e-mailadres',
				'probeer het misschien nog eens',
			);
			$message = $list[array_rand($list, 1)];

			return View::make('login', compact('username', 'password', 'message'));
		}

		return Redirect::to('/');
	}

	/**
	 * @return View
	 */
	public function getVine ()
	{
		return View::make('login');
	}
}