<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "Images";
    
        protected $fillable = [
            'title','content','idAlbum','img','idUser'
        ];
    
        public function album(){
            return $this->belongsTo('App\Album','idAlbum','id');
        }
    
        public function user(){
            return $this->belongsTo('App\User','idUser','id');
        }
    
        public function comment(){
            return $this->hasMany('App\Comment','idImg','id');
        }
    
        public function tag(){
            return $this->hasMany('App\Tag','idImg','id');
        }
}
