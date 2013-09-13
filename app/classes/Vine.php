<?php

use Guzzle\Http\Client;

class Vine {

	private $client;
	private $session_id;

	public function __construct()
	{
		// guzzle client
		$this->client = new Client(Config::get('vine.base_url'));
		//$this->client->setUserAgent('com.vine.iphone/1.0.3 (unknown, iPhone OS 6.1.0, iPhone, Scale/2.000000)');
		$this->load_session();
	}

	public function set_session($session_id)
	{
		$this->session_id = $session_id;
		return $this;
	}

	public function user($id)
	{
		$request = $this->client->get('/users/me', $this->get_headers());
		return $request->send()->json()['data'];
	}

	public function login($username, $password)
	{
		// build array
		$creds = array(
			'username' => $username,
			'password' => $password,
		);

		try
		{
			// perform post
			return $this->client->post('/users/authenticate', array(), $creds)->send()->json()['data'];
		}
		catch (Guzzle\Http\Exception\ClientErrorResponseException $e)
		{
			return false;
		}
	}

	public function logout()
	{
		// perform delete
		$request = $this->client->delete('/users/authenticate', $this->get_headers());
		$response = $request->send()->json();

		// load general session id
		$this->load_session();

		// report back
		return $response['success'];
	}

	public function newest($tag, $last = null)
	{
		// build headers
		$headers = $this->get_headers();

		// define endpoint
		$endpoint = "/timelines/tags/$tag";

		// empty array()
		$vines = array();

		// pull
		$response = $this->client->get($endpoint, $headers)->send()->json()['data'];

		// process results
		$new_vines = $this->process($response, $last);
		$vines = array_merge($vines, $new_vines);

		// pull next batch
		while ($response['nextPage'])
		{
			// prepare paging
			$page   = $response['nextPage'];
			$anchor = $response['anchor'];

			// pull next batch
			$response = $this->client->get("$endpoint?page=$page&anchor=$anchor", $headers)->send()->json()['data'];

			// process results
			$new_vines = $this->process($response, $last);
			$vines = array_merge($vines, $new_vines);
		}

		// report back
		return $vines;
	}

	public function vine($vine_id)
	{
		$request = $this->client->get("/timelines/posts/$vine_id", $this->get_headers());
		return $request->send()->json()['data']['records'][0];
	}

	public function like($vine_id)
	{
		$request = $this->client->post("/posts/$vine_id/likes", $this->get_headers());
		return $request->send()->json();
	}

	public function dislike($vine_id)
	{
		$request = $this->client->delete("/posts/$vine_id/likes", $this->get_headers());
		return $request->send()->json();
	}

	protected function load_session()
	{
		// reuse
		$cache_key = 'vine_session_id';

		// get cached session id
		if (Cache::has($cache_key))
		{
			$this->session_id = Cache::get($cache_key);
			return $this;
		}

		// login
		$user = $this->login(
			Config::get('vine.username'), 
			Config::get('vine.password')
		);

		if ( ! $user) return false;
		
		// save the session key
		$this->session_id = $user['key'];

		// cache it!
		Cache::put($cache_key, $this->session_id, 60 * 24);

		// allow chaining
		return $this;
	}

	protected function get_headers()
	{
		return array(
			'vine-session-id' => $this->session_id,
		);
	}

	private function process(&$data, $last)
	{
		// if no records provided: end is reached
		if ( ! isset($data['records']) || empty($data['records'])) return array();

		// init
		$vines = array();

		// loop vines
		foreach ($data['records'] as &$vine) 
		{
			if ($vine['postId'] != $last)
			{
				$vines[$vine['postId']] = $vine;
			}
			else
			{
				$data['nextPage'] = false;
				break;
			}
		}

		// report back
		return $vines;
	}
}