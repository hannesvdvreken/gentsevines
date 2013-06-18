<?php

class Vine extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vines';
	protected $guarded = array();

	/*
	 |--------------------------------------------------------------------------
	 | Valid
	 |--------------------------------------------------------------------------
	 */

	public function scopeValid($query) {

		$query->where('invalid', 0);
	}
}