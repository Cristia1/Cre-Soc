<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Comment;

class LikeController extends Controller
{
    public function like(Request $request, $itemType, $id)
    {
        $model = $this->getModel($itemType);
        $item = $model::findOrFail($id);

        if ($item->likes()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Already liked'], 400);
        }

        $item->likes()->create(['user_id' => auth()->id()]);

        return response()->json(['message' => 'Liked', 'likes_count' => $item->likes()->count()]);
    }


    public function unlike(Request $request, $itemType, $id)
    {
        $model = $this->getModel($itemType);
        $item = $model::findOrFail($id);

        $like = $item->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Unliked', 'likes_count' => $item->likes()->count()]);
        }

        return response()->json(['message' => 'Not liked'], 400);
    }


    public function getLikes($itemType, $id)
    {
        $model = $this->getModel($itemType);
        $item = $model::findOrFail($id);

        return response()->json(['likes_count' => $item->likes()->count(), 'likes' => $item->likes()->get()]);
    }

    
    private function getModel($itemType)
    {
        $models = [
            'photo' => Photo::class,
            'cover' => Photo::class,
            'post' => Post::class,
            'comment' => Comment::class,
        ];

        return $models[$itemType] ?? abort(404, 'Invalid item type');
    }
}
