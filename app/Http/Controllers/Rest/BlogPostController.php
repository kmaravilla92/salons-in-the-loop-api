<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entities\BlogPost as BlogPostEntity;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogPostEntity::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug_or_id)
    {
        $blog_post = new BlogPostEntity;
        if(is_int($slug_or_id)){
            $blog_post = $blog_post->where('id', $slug_or_id);
        }else if(is_string($slug_or_id)){
            $blog_post = $blog_post->where('slug', $slug_or_id);
        }

        try{
            $blog_post = $blog_post->firstOrFail();
        }catch(ModelNotFoundException $mnfe){
            return response('Post not found with ID or Slug of `' . $slug_or_id . '`' , 404);
        }

        $blog_post->next_post = null;

        if(isset($request->include_next_post)){
            $next_blog_post = new BlogPostEntity;
            $next_blog_post_id = $blog_post->id + 1;
            try{
                $next_blog_post = $next_blog_post->findOrFail($next_blog_post_id);
            }catch(ModelNotFoundException $mnfe){
                // Go back to first record
                $next_blog_post = BlogPostEntity::first();
            }
            $blog_post->next_post = $next_blog_post;
        }

        return $blog_post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
