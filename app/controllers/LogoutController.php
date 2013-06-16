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

		// do request
		$this->curl->create($this->base . '/users/authenticate');
		$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: $user->vine_session_id"));
		$this->curl->option(CURLOPT_CUSTOMREQUEST, 'DELETE');
		
		$response = json_decode($this->curl->execute());

		if (isset($response->success) && $response->success) {
			// something went wrong
		}

		Session::flush();

		return Redirect::to('/');
	}
}