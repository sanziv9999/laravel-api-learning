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
                'message' => "Post added successfully",
                'post' => $post->id
            ], 200);
        }catch(\Exception $e ){
            return response()->json([
                'error' => $e -> getMessage()
            ],403);
        }

    }
}
