<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = "albums";
    
    protected $fillable = [
        'title', 'idUser', 'idAlbumf'
    ];
        
    public function image() {
        return $this->hasMany('App\Image','idAlbum','id');
    }
        
    public function album() {
        return $this->hasMany('App\Album','idAlbumf','id');
    }

    public function albumf() {
        return $this->belongsTo('App\Album','idAlbumf','id');
    }

    public function user(){
        return $this->belongsTo('App\User','idUser','id');
    }

    public function destroyA(){
        $images = $this->image;
        $albums = $this->album;
        foreach($images as $i){
            $comments = $i->comment;
            foreach($comments as $c){
                $c->delete();
            }
            $tags = $i->tag;
            foreach($tags as $t){
                $t->delete();
            }
            File::delete('storage/upload/'.$i->img);
            $i->delete();
        }
        foreach($albums as $a){
            $a->destroyA();
        }
        $this->delete();
    }

    public function getPath(){

    }
}
