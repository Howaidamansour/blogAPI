<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts),
        'all post retrive succcesfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'content'=>'required',
    
        ]);
        if ($validator->fails()){
            return $this->sendError('please validate error',$validator->errors() );
        }

        $post = Post::create($input);
        return $this->sendResponse(new PostResource($post), 'post added successfully');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(is_null($post)){
            return $this->sendError('post not found');   
        }

        return $this->sendResponse(new PostResource($post), 'post found successfully');
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'content'=>'required',
    
        ]);
       
        $post->title = $input['title'];
        $post->content=$input['content'];
        $post->save();

        if(is_null($post)){
            return $this->sendError('post not found');   
        }

        return $this->sendResponse(new PostResource($post), 'post found successfully');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse(new PostResource($post), 'post deleted successfully');
    }
}
