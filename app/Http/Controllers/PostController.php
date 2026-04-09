<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

class PostController extends Controller
{
    //

    public function addNewPost(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'text' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $post = new Post();
            $post-> title = $request->title;
            $post-> text = $request->text;
            $post-> user_id = auth()-> user() ->id;
            $post-> save();

            return response()->json([
                'message' => "Post added successfully"
            ], 200);
        }catch(\Exception $e ){
            return response()->json([
                'error' => $e -> getMessage()
            ],403);
        }

    }

    //edit post approach 1
    public function editPost(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'post_id' => 'required|integer|exists:posts,id',
                'title'   => 'required|string|max:255',
                'text'    => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $post_data = Post::find($request->post_id);

            if (!$post_data) {
                return response()->json([
                    'error' => 'Post not found'
                ], 404);
            }

            $post_data->update([
                'title' => $request->title,
                'text'  => $request->text,
            ]);

            return response()->json([
                'message' => "Post updated successfully"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }
    }


    //edit post approach 2
     public function editPostById(Request $request, $post_id){
        $validator = Validator::make(
            $request->all(),
            [
                'title'   => 'required|string|max:255',
                'text'    => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $post_data = Post::find($post_id);

            if (!$post_data) {
                return response()->json([
                    'error' => 'Post not found'
                ], 404);
            }

            $post_data->update([
                'title' => $request->title,
                'text'  => $request->text,
            ]);

            return response()->json([
                'message' => "Post updated successfully"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }
    }




    //get all posts
    public function getAllPosts(Request $request){
        try{
            $posts = Post::latest()->get();
            return response()->json([
                'posts' => $posts
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }
        
    }


    //delete post by id

    public function deletePostById(Request $request, $post_id){
            try {
                $post_data = Post::find($post_id);

                if (!$post_data) {
                    return response()->json([
                        'error' => 'Post not found'
                    ], 404);
                }

                $post_data->delete();

                return response()->json([
                    'message' => "Post updated successfully"
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 403);
            }
        }


}
