<?php

class APIController extends BaseController {

	public function __construct () {
		parent::__construct();

		$this->beforeFilter(function()
        {
            if (!Session::has('user'))
            {
            	return Response::make('not authenticated', 401);
            }
        }, array('on' => 'post'));

	}

	/**
	 *
	 */
	public function getLoad ($last_vine_id, $tag) {

		$last_vine = Vine::find($last_vine_id);

		$set = Vine::where('tag', $tag)
		           ->where('posted_at', '<', $last_vine->posted_at)
		           ->orderBy('posted_at', 'desc')
		           ->take(1)->get();

		foreach ($set as $v) {
			// append like data
			$v->likes = $this->likes($v);

			// append user data
			$v->user = $this->user($v);
		}

		return Response::json($set);
	}

	/**
	 *
	 */
	public function getVine ($vine_id, $type = null) {

		// check if we know about this vine
		$vine = Vine::find($vine_id);
		if (!$vine) {
			return Response::make('we never heard about this vine...', 404);
		}

		switch ($type) {
			case 'likes':

				return Response::json($this->likes($vine));

			case 'comments':

				return Response::json($this->comments($vine));

			default:
				// append like data
				$vine->likes = $this->likes($vine);

				// append user data
				$vine->user = $this->user($vine);

				return Response::json($vine);
		}
	}

	public function postLike ($vine_id) {

		return $this->toggleLike($vine_id, true);

	}

	public function postDislike ($vine_id) {

		return $this->toggleLike($vine_id, false);
	}

	protected function toggleLike ($vine_id, $like = true) {
		// POST or DELETE the like?
		$method = $like ? 'POST': 'DELETE';

		// check if we know about this vine
		$vine = Vine::find($vine_id);
		if (!$vine) {
			return Response::make('we never heard about this vine...', 404);
		}

		// get user
		$user = User::find(Session::get('user'));

		// do request
		$this->curl->create($this->base . "/posts/$vine_id/likes");
		$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: {$user->vine_session_id}"));
		$this->curl->option(CURLOPT_CUSTOMREQUEST, $method);
		
		$response = json_decode($this->curl->execute());

		return Response::json($response);
	}

	protected function user ($vine) {
		// append user data
		$user = User::find($vine->user_id)->toArray();

		// crucial:
		unset($user['vine_session_id']);
		unset($user['email']);

		return $user;
	}

	protected function likes ($vine) {
		// add caching

		$vine_session_id = Config::get('vine.vine-session-id');

		// do request
		$this->curl->create($this->base . "/posts/$vine->id/likes");
		$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: $vine_session_id"));

		// pull data
		$response = json_decode($this->curl->execute());

		// return
		return array('count' => $response->data->count);
	}

	protected function comments ($vine) {
		// add caching

		// pull data

		// return
		return array('test' => true);
	}

}