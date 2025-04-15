<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function index (){
        $posts=Post::all();
        return view("posts.index",["posts"=>$posts]);         
    }

    function show($id){
        $post= Post::find($id);
        return view("posts.show",["post"=>$post]);                 
    }

    function create(){        
        return view('posts.create');
    }
    
    function store(StorePostRequest $request){

        $post= new Post($request->validated());
        $post->title=$request->title;
        $post->body=$request->body;
        $post->user_id=$request->user_id;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $post->image = $path;
        }              
        $post->save();

        return redirect()->route('posts.index');
    }

    function edit($id){
        $post=Post::find( $id );
        return view('posts.edit',["post"=>$post]);
    }

    function update($id, StorePostRequest $request){
        // $data= $request->all();

        $post= Post::find( $id );
        $post->title=$request->title;
        $post->body=$request->body;
        $post->user_id=$request->user_id;
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('uploads', 'public');
            $post->image = $filename;
        }    
        $post->save();

        return redirect()->route('posts.index');
    }

    function destroy($id){
        
        // Post::destroy($id);
        $post=Post::find( $id );
        $post->delete();

        return redirect(route("posts.index"));
    }

}
