<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";
    
        protected $fillable = [
            'idImg', 'content', 'idUser',
        ];
    
        public function image(){
            return $this->belongsTo('App\Image','idImg','id');
        }

        public function user(){
            return $this->belongsTo('App\User','idUser','id');
        }
}
