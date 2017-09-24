<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Image;
use Auth;
use Input;

class TagsController extends Controller
{
    public function store($idImg) {
        $content = Input::get('tag');
        $idUser = Auth::user()->id;
        $tags = Tag::where('content', '=', $content)->get();
        foreach($tags as $t) {
            if($t->idImg == $idImg){
                return redirect()->back()->with(['type'=>'warning','msg'=>"Tag #'$content' is existed!"]);
            }
        }
        Tag::create([
            'content' => $content,
            'idImg' => $idImg,
            'idUser' => $idUser
        ]);
        return redirect()->route('image.show',$idImg);      
    }

    public function findimages($tag) {
        $idUser = Auth::user()->id;
        $tags = Tag::where('content', '=', $tag)->get();
        $images = Image::all();
        return view('image.tag',compact('tags','images','tag','idUser'));        
    }

    public function destroy($idTag,Request $request) {
        if($request->ajax()){
            $idTag = (int) $request->get('idTag');
            $tag = Tag::find($idTag);
            if(!empty($tag)){
                $tag->delete();
            }
            return "OK";
        }
    }
}
