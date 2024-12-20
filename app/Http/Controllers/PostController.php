<?php

namespace App\Http\Controllers;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use App\Models\like;
use App\Models\Profile;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($id)
    {
        $posts = Post::where('user_id', 'photo', 'comment', 'friend','like', 'profile')->get();
    }


    public function openPost($id)
    {
        $post = Post::with('comments')->find($id);
        
        if ($post) {
            $firstComment = $post->comments->first(); 
    
            return response()->json([
                'success' => true,
                'post' => $post,
                'comment' => $firstComment ? $firstComment : 'No comments available' 
            ]);
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'Post not found'
            ]);
        }
    }
    
}
