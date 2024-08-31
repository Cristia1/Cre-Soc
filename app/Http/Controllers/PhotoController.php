<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        return response()->json($photos);
    }

    public function show($id)
    {
        $photo = Photo::findOrFail($id);
        return response()->json($photo);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:cover,profil',
        ]);
    
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User is not authenticated']);
        }
    
        $filename = $userId . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/photos/' . $userId, $filename);
    
        $type = $request->input('type');
    
        $photo = Photo::where('user_id', $userId)->where('type', $type)->first();
    
        if ($photo) {
            Storage::delete($photo->image);
            $photo->image = $path;
            $photo->save();
        } else {
            $photo = new Photo();
            $photo->user_id = $userId;
            $photo->type = $type;
            $photo->image = $path;
            $photo->save();
        }
    
        $imageUrl = Storage::url($path);
    
        return response()->json(['success' => true, 'imageUrl' => $imageUrl]);
    }
    
    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Storage::delete($photo->image);
        $path = $request->file('image')->store('public/photos');
        $photo->user_id = Auth::id();
        $photo->image = $path;
        $photo->save();

        return response()->json(['success' => true, 'message' => 'Photo updated successfully.']);
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        Storage::delete($photo->image);
        $photo->delete();

        return response()->json(['success' => true, 'message' => 'Photo deleted successfully.']);
    }

    public function PhotoCover(): JsonResponse
    {
        $userId = auth()->id();
        $photo = Photo::where('user_id', $userId)->where('type', 'cover')->first();
        if ($photo) {
            $coverUrl = Storage::url($photo->image);
            return response()->json(['success' => true, 'coverUrl' => $coverUrl]);
        } else {
            return response()->json(['success' => false, 'message' => 'No cover image found']);
        }
    }

    public function PhotoProfil(): JsonResponse
    {
        $userId = auth()->id();
        $photo = Photo::where('user_id', $userId)->where('type', 'profil')->first();

        if ($photo) {
            $profilUrl = Storage::url($photo->image);
            return response()->json(['success' => true, 'profilUrl' => $profilUrl]);
        } else {
            return response()->json(['success' => false, 'message' => 'No profile image found']);
        }
    }
}