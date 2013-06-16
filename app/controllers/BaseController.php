<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout ()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function __construct ()
    {
    	$this->curl = new Curl();
    	$this->base = 'https://api.vineapp.com';
    }

}