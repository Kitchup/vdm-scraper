<?php

namespace App\Repositories;

use App\Post;
use Underscore\Types\Arrays;

class PostRepository extends Repository
{
	protected $model;

	public function __construct(Post $model){parent::__construct($model);}

	/**
	* Querry database using appropriate filters
	*
	* @var string
	*/
	public function filter (array $filters)
	{
		$query = $this->model;

		// 'from' filter : lower limit for dates in the query
		$fromFilter = Arrays::get($filters, 'from');
		if($fromFilter)
		{
			$query = $query->where('date', '>=', $fromFilter);
		}

		// 'to' filter : upper limit for dates in the query
		$toFilter = Arrays::get($filters, 'to');
		if($toFilter)
		{
			$query = $query->where('date', '<=', $toFilter);
		}

		// 'author' filter : adds author property to where clause
		$authorFilter = Arrays::get($filters, 'author');
		if($authorFilter)
		{
			$query = $query->where('author', '=', $authorFilter);
		}

		return $query->orderBy('date', 'desc')->get();
	}
}

?>