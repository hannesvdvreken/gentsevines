<?php

class AppController extends BaseController {

	/**
	 *
	 */
	public function getIndex () {
		$tag = Config::get('vine.default-tag');

		// get vines
		$set = Vine::where('tag', $tag)->orderBy('posted_at', 'desc')->take(5)->get();

		$vines = array();
		foreach ($set as $v) {
			$vines[] = $v->id;
		}

		// get logged in user
		if (Session::has('user')) {
			$user = User::find(Session::get('user'));
		}
		
		return View::make('index', compact('vines', 'user', 'tag'));
	}

	public function getTerms () {

		// get logged in user
		if (Session::has('user')) {
			$user = User::find(Session::get('user'));
		}

		return View::make('terms', compact('user'));

	}
}