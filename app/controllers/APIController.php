<?php

use Models\Vine as Vine_model;

class APIController extends BaseController {

	public function __construct () 
	{
		//parent::__construct();
		$me = $this;

		$this->beforeFilter(function()
		{
			if ( ! Session::has('user'))
			{
				return Response::make('not authenticated', 401);
			}
		}, array('on' => 'post|delete'));

		$this->beforeFilter(function()
		{
			if (Session::has('user'))
			{
				$this->user = User::find(Session::get('user'));
			}
		});
	}

	public function getStream ($last_vine_id, $tags) 
	{
		// process input
		$tags = explode('+', $tags);
		$limit = Input::get('limit', 1);

		// get date
		$last_vine = Vine_model::find($last_vine_id);

		// get next vines
		$set = Vine_model::where('posted_at', '<', $last_vine->posted_at)
		                 ->whereIn('tag', $tags)
		                 ->valid()
		                 ->orderBy('posted_at', 'desc')
		                 ->take($limit)->get();

		// pre-load users
		foreach ($set as &$v) 
		{
			$v->user;
		}

		return Response::json($set);
	}

	public function getVine ($vine_id) 
	{
		if ($fault = $this->check_vine_id($vine_id))
		{
			return $fault;
		}

		$vine = Vine_model::find($vine_id);

		// pre-load
		$vine->user;

		// get current vine data from vine.co
		$v = new Vine();
		$v->set_session($this->user->vine_session_id);
		$vine_data = $v->vine($vine_id);

		$vine->likes = array(
			'user_like' => $vine_data['liked'],
			'count' => $vine_data['likes']['count'],
		);

		return Response::json($vine);
	}

	public function postVine ($vine_id, $type) 
	{
		// checks
		if ($fault = $this->check_type($type)) 
		{
			return $fault;
		}

		if ($fault = $this->check_vine_id($vine_id))
		{
			return $fault;
		}

		switch ($type)
		{
			case 'like':
				return $this->like_vine($vine_id);
				break;
		}
	}

	public function deleteVine ($vine_id, $type) 
	{
		// checks
		if ($fault = $this->check_type($type)) 
		{
			return $fault;
		}

		if ($fault = $this->check_vine_id($vine_id))
		{
			return $fault;
		}

		// 
		switch ($type)
		{
			case 'like':
				return $this->dislike_vine($vine_id);
				break;
		}
	}

	protected function like_vine($vine_id)
	{
		// load stuff
		$v = new Vine();
		$v->set_session($this->user->vine_session_id);

		// perform like
		// return success
		return Response::json(
			$v->like($vine_id)
		);
	}

	protected function dislike_vine($vine_id)
	{
		// load stuff
		$v = new Vine();
		$v->set_session($this->user->vine_session_id);

		// perform like deletion
		// return success
		return Response::json(
			$v->dislike($vine_id)
		);
	}

	protected function check_type($type)
	{
		if ( ! in_array($type, array('like'))) 
		{
			return Response::make('unsupported interaction', 404);
		}
	}

	protected function check_vine_id($vine_id)
	{
		// check if we know about this vine
		$vine = Vine_model::find($vine_id);

		// check vine
		if (!$vine)
		{
			return Response::make('we never heard about this vine...', 404);
		}
	}
}