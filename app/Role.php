<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =['role'];

    public function postings(){
    	return $this->hasManyThrough(Posting::class,User::class,'role_id','user_id');
    }
}
