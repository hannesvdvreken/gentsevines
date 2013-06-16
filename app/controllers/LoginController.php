<?php

class LoginController extends BaseController {

	public function __construct () {
		parent::__construct();

		$this->beforeFilter(function()
        {
            if (App::environment() == 'production' &&
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

		// do request
		$response = json_decode(
			$this->curl->simple_post(
				$this->base . '/users/authenticate',
				compact('username', 'password')
			)
		);

		if (isset($response->success) && $response->success) {
			// get data
			$id              = $response->data->userId;
			$vine_session_id = $response->data->key;

			// reset curl
			$this->curl->create($this->base . '/users/me');
			$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: $vine_session_id"));
			
			// get user
			$user_data = json_decode($this->curl->execute());
			$user_data = $user_data->data;
			
			// session
			Session::put('user', $id);

			// db
			$user = User::find($id);

			if ($user) {
				$user->vine_session_id = $vine_session_id;
				$user->email     = $user_data->email;
				$user->followers = $user_data->followerCount;
				$user->avatar    = $user_data->avatarUrl;
				$user->username  = $user_data->username;
				$user->twitter   = $user_data->twitterId;
				$user->save();
			} else {
				$email     = $user_data->email;
				$followers = $user_data->followerCount;
				$avatar    = $user_data->avatarUrl;
				$username  = $user_data->username;
				$twitter   = $user_data->twitterId;

				$user = User::create(compact('id', 'vine_session_id', 'email', 'followers', 
					                         'avatar', 'username', 'twitter'));
			}
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