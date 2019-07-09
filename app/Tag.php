<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable =['name'];

    public function postings(){
    	return $this->morphedByMany(Posting::class,'taggable');
    }
    public function portfolio(){
    	return $this->morphedByMany(Portfolio::class,'taggable');
    }
}
