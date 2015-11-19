<?php

 namespace App\Transformers;

 use App\Transformers\Transformer;

 class PostTransformer extends Transformer
 {
 	/**
	* Transforms a 'Post' entity into its JSON representation
	* Visible filds : Id, content, date, author
	*
	* @param Post $item : the Post entity
	* @return JSON
	*/
 	public function transform($item)
 	{
 		return 
 		[ 
 			'id' 	  => $item['id'],
 			'content' => $item['content'],
 			'date'    => $item['date'],
 			'author'  => $item['author']
 		];
 	}
 }

?>