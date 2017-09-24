<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use File;
use App\Album;
use App\Image;

class AlbumsController extends Controller
{
    public function index() {
        $albums = Album::where('idAlbumf', '=', 0)->paginate(8);
        return view('album.index',compact('albums'));        
    }

    public function new($idAlbumf) {
        return view('album.new',compact('idAlbumf'));        
    }

    public function store($idAlbumf,Request $request) {
        $this->validate($request,[
            'title' => 'unique:albums'
        ]);
        $title = Input::get('title');
        $idUser = Auth::user()->id;

        Album::create([
            'title' => $title,
            'idUser'=> $idUser,
            'idAlbumf' => $idAlbumf
        ]);
        if($idAlbumf == 0) {
            return redirect()->route('album.index')->with(['type'=>'success','msg'=>'Success to add new album!']);      
        }
        else {
            return redirect()->route('album.show', [$idAlbumf])->with(['type'=>'success','msg'=>'Success to add new album!']);
        } 
    }

    public function show($idAlbum) {
        $album = Album::find($idAlbum);
        return view('album.show',compact('album'));        
    }

    public function destroy($idAlbum) {
        $album = Album::find($idAlbum);
        $idAlbumf = $album->idAlbumf;
        $name = $album->title;
        $album->destroyA();
        if($idAlbumf == 0) {
            return redirect()->route('album.index')->with(['type'=>'danger','msg'=>"You've deleted album '$name' and all of its contents!"]);      
        }
        else {
            return redirect()->route('album.show', [$idAlbumf])->with(['type'=>'danger','msg'=>"You've deleted album '$name' and all of its contents!"]);
        } 
    }
}
