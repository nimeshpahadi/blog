<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model

{


    public $table = "comments";

    public $fillable = ["name","email","comment","approved","post_id"];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
