<?php

class LogoutController extends BaseController {

	/**
	 *
	 * @return Redirect
	 */
	public function getVine ()
	{
		// get user
		$user = User::find(Session::get('user'));

		if ($user) {
			// do request
			$v = new Vine();
			$v->set_session($user->vine_session_id);
			$logged_out = $v->logout();

			if ($logged_out)
			{
				Session::flush();
			}
		}
		else
		{
			Session::flush();
		}

		return Redirect::to('/');
	}
}