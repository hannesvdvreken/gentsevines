<?php

class AppController extends BaseController {

	public function __construct() {

		parent::__construct();

		$this->user = null;

		// get logged in user
		if (Session::has('user')) {

			$this->user = User::find(Session::get('user'));

		}
	}

	/**
	 *
	 */
	public function getIndex ($vine_id = null) {

		if ($vine_id)
		{
			return $this->one_vine($vine_id);
		}
		else
		{
			return $this->all_vines();
		}
		
	}

	public function getTerms () {

		$user = $this->user;

		return View::make('terms', compact('user'));

	}

	protected function one_vine($vine_id) {

		$user = $this->user;

		$exists = Vine::where('id', $vine_id)->count();

		if ($exists) 
		{
			return View::make('vine', compact('vine_id'));
		}
		else 
		{
			return Response::make('doesn\'t ring a bell...', 404);
		}

	}

	protected function all_vines() {

		$tags = Config::get('vine.tags');

		// get vines
		$set = Vine::whereIn('tag', $tags)->valid()->orderBy('posted_at', 'desc')->take(5)->get();

		$vines = array();

		foreach ($set as $v) {

			$vines[] = $v->id;

		}

		// get logged in user
		$user = $this->user;
		
		return View::make('index', compact('vines', 'user', 'tags'));
	}

	public function missingMethod( $args ) {

		if (count($args) == 1) {

			return $this->one_vine(reset($args));

		}
		else
		{

			return Response::make('unknown request endpoint', 404);

		}
	}
}