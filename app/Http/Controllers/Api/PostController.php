<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\ModelApi\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    //ini untuk read all
    public function index()
    {
        $posts = auth()->user()->posts;
 
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
 
    //ini untuk read by id
    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 400);
    }
 
    //ini untuk create
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
 
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
 
        if (!$post)
            return response()->json([
                'success' => false,
                'message' => 'Post could not be added'
                
            ], 500);
        else
            return response()->json([
                'success' => true,
                'data' => $post->toArray()
            ]);
    }
 

    //ini untuk update
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $post->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post could not be updated'
            ], 500);
    }
 
    //ini untuk delete
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post could not be deleted'
            ], 500);
        }
    }
}
