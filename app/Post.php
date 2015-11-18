<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Allowing properties for mass assignement
    protected $fillable = [
    	'vdm_id',
    	'content',
    	'date',
    	'author'
    ];
}
