<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Models\Vine as Vine_model;

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
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// init
		$v = new Vine();

		// set tags array
		$tag = $this->option('tag');
		$tags = $tag ? array($tag) : Config::get('vine.tags');

		// loop
		foreach ($tags as $tag) 
		{
			// get last id
			$last_vine = Vine_model::last($tag)->first();
			$last = empty($last_vine) ? null : $last_vine['id'];

			// pull newest vines with tag
			$vines = $v->newest($tag, $last);
			
			foreach ($vines as $vine_data) 
			{
				$this->save_vine($vine_data, $tag);
			}
		}
	}

	function save_vine ($vine_data, $tag) 
	{
		// check if duplicate
		$v = Vine_model::find($vine_data['postId']);
		if ($v) return false;

		// get required vine data
		$id          = $vine_data['postId'];
		$venue       = $vine_data['foursquareVenueId'];
		$user_id     = $vine_data['userId'];
		$thumbnail   = $vine_data['thumbnailUrl'];
		$description = $vine_data['description'];
		$video       = $vine_data['videoUrl'];
		$posted_at   = $vine_data['created'];

		// save vine
		Vine_model::create(compact('id', 'venue', 'user_id', 'thumbnail', 'description', 'video', 'posted_at', 'tag'));

		// get user data
		$id       = $vine_data['userId'];
		$username = $vine_data['username'];
		$avatar   = $vine_data['avatarUrl'];
		$location = isset($vine_data['location']) ? $vine_data['location'] : null;

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
			User::create(compact('id', 'avatar', 'username', 'location'));
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
			//
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
			array('tag', null, InputOption::VALUE_OPTIONAL, 'A tag to filter vines.'),
		);
	}

}