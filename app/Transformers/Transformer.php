<?php

 namespace App\Transformers;

 use Underscore\Types\Arrays;

 abstract class Transformer
 {
 	public function transformCollection(array $collection)
 	{
 		return Arrays::invoke($collection, [$this, 'transform']);
 	}

 	public abstract function transform($item);
 }



?>