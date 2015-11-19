<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
	protected $model;

	public function __construct(Model $model){$this->model=$model;}

	public abstract function filter (array $filters);


	/**
	* Saves entity into the database
	*
	* @param  array $properties : the properties of the entity
	* @return array  : the entity
	*/
	public function create ($properties){return $this->model->create($properties)->toArray();}

	/**
	* Finds entity by id
	*
	* @param int $id : the id of the entity
	* @return array  : if found the entity, null otherwise
	*/
	public function find($id)
	{
		$model =$this->model->find($id);
		if($model)
		{
			return $model->toArray();
		}

		return null;
	}
}

?>