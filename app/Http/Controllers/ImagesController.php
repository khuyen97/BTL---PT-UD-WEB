<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use File;
use App\Album;
use App\Image;
use App\Comment;
use App\User;

class ImagesController extends Controller
{
    public function choose($idAlbum) {
        return view('image.choose',compact('idAlbum'));        
    }

    public function addimg($idAlbum,Request $request){
        $this->validate($request,[
            'img' => 'image'
        ]);
        $name = Input::file('img')->getClientOriginalName();
        $img = str_random(4)."_". $name;
        while(file_exists("storage/upload/".$img)){
            $img = str_random(4)."_". $name;
        }
        Input::file('img')->move('storage/upload', $img);
        $idUser = Auth::user()->id;
        Image::create([
            'idUser' => $idUser,
            'img' => $img,
            'idAlbum' => $idAlbum
        ]);
        return redirect()->route('image.addinfo',[$img]);
    }

    public function addinfo($img) {
        return view('image.addinfo',compact('img'));        
    }

    public function complete($img, Request $request) {
        $this->validate($request,[
            'title' => 'max:20',
            'content' => 'max:100',
        ]);

        $title = Input::get('title');
        $content = Input::get('content');
        $idUser = Auth::user()->id;
        $image = Image::where('img', '=', $img)->first();
        $image->update([
            'title' => $title,
            'content' => $content
        ]);
        return redirect()->route('album.show',$image->idAlbum)->with(['type'=>'success','msg'=>"Success to post your image!"]);     
    }

    public function show($idImg) {
        $image = Image::find($idImg);
        $idUser = Auth::user()->id;
        $images = Image::all();
        return view('image.show',compact('image','images','idUser'));        
    }

    public function destroy($id) {
        $image = Image::find($id);
        $idAlbum = $image->idAlbum;
        $comments = $image->comment;
        foreach($comments as $c){
            $c->delete();
        }
        $tags = $image->tag;
        foreach($tags as $t){
            $t->delete();
        }
        File::delete('storage/upload/'.$image->img);
        $image->delete();

        return redirect()->route('album.show',$idAlbum)->with(['type'=>'danger','msg'=>"You've deleted one image!"]);       
    }
}
