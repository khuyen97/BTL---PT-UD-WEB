<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    
        protected $fillable = [
            'idUser','idImg', 'content',
        ];
    
        public function image(){
            return $this->belongsTo('App\Image','idImg','id');
        }
    
        public function user(){
            return $this->belongsTo('App\User','idUser','id');
        }
}
