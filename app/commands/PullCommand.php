<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PullCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vine:pull';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pull vines with specific tags.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->curl = new Curl();
		$this->base = Config::get('vine.base_url');
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// TODO get tag from arguments list
		$tag = $this->argument('tag');

		// get settings
		$vine_session_id = Config::get('vine.vine-session-id');

		// init
		$this->curl->create($this->base . "/timelines/tags/$tag?size=1");
		$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: $vine_session_id"));

		// do request
		$response = json_decode($this->curl->execute());

		// prepare array
		$vines = array();

		// try existance
		$id = $response->data->records[0]->postId;
		$vine = Vine::where('id', $id)->where('tag', $tag)->first();

		// repeat
		$page   = $response->data->nextPage;
		$anchor = $response->data->anchor;

		while (!$vine && !is_null($page)) {
			// add to array
			$vines[] = $response->data->records[0];

			// prep curl
			$this->curl->create($this->base . "/timelines/tags/$tag?size=1&page=$page&anchor=$anchor");
			$this->curl->option(CURLOPT_HTTPHEADER, array("vine-session-id: $vine_session_id"));

			// exec
			$response = json_decode($this->curl->execute());

			// failsafe
			if (count($response->data->records) < 1) {
				$page = null;
				break;
			}

			// try existance
			$id = $response->data->records[0]->postId;
			$vine = Vine::where('id', $id)->where('tag', $tag)->first();

			// repeat
			$page   = $response->data->nextPage;
			$anchor = $response->data->anchor;

		}

		foreach ($vines as $vine_data) {
			
			// get required vine data
			$id          = $vine_data->postId;
			$venue       = $vine_data->foursquareVenueId;
			$user_id     = $vine_data->user->userId;
			$thumbnail   = $vine_data->thumbnailUrl;
			$description = $vine_data->description;
			$video       = $vine_data->videoUrl;
			$posted_at   = $vine_data->created;

			// save vine
			Vine::create(compact('id', 'venue', 'user_id', 'thumbnail', 'description', 'video', 'posted_at', 'tag'));

			// get user data
			$user_data = $vine_data->user;

			$id       = $user_data->userId;
			$username = $user_data->username;
			$avatar   = $user_data->avatarUrl;

			// don't duplicate
			$user = User::find($id);

			if ($user) {
				// update
				$user->username = $username;
				$user->avatar   = $avatar;

				$user->save();
			}
			else
			{
				// create
				User::create(compact('id', 'avatar', 'username'));
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('tag', InputArgument::REQUIRED, 'A tag to filter vines.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}