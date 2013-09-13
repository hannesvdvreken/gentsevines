<?php

namespace Models;

class Vine extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vines';
	protected $guarded = array();

	/*
	 |--------------------------------------------------------------------------
	 | Relations
	 |--------------------------------------------------------------------------
	 */
	public function user()
    {
        return $this->belongsTo('User');
    }

	/*
	 |--------------------------------------------------------------------------
	 | Valid
	 |--------------------------------------------------------------------------
	 */

	public function scopeValid($query) 
	{
		$query->where('invalid', 0);
	}

	public function scopeLast($query, $tag)
	{
		// set field
		$field = 'posted_at';

		// get max
		$max = $this->where('tag', $tag)->max($field);

		// return field
		$query->where('tag', $tag)->where($field, $max);
	}
}