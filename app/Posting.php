<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    protected $fillable =[
    	'user_id','title','body'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

     public function categories(){
    	return $this->belongsToMany(Category::class);
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
    
    public function tags(){
    	return $this->morphToMany(Tag::class,'taggable');
    }


}
