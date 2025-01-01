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
            'is_primary' => 'nullable|boolean',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User is not authenticated']);
        }

        // Generate a unique file name for the image
        $filename = $userId . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/photos/' . $userId, $filename);

        $type = $request->input('type');
        $isPrimary = $request->input('is_primary', false); // default: false
        $existingPrimaryPhoto = Photo::where('user_id', $userId)->where('type', $type)->where('is_primary', true)->first();
        if (!$existingPrimaryPhoto) {
            $isPrimary = true; 
        }

        if ($isPrimary) {
            Photo::where('user_id', $userId)->where('type', $type)->update(['is_primary' => false]);
        }

        $photo = new Photo();
        $photo->user_id = $userId;
        $photo->type = $type;
        $photo->image = $path;
        $photo->is_primary = $isPrimary;
        $photo->save();

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
        if ($photo->is_primary) {
            $replacementPhoto = Photo::where('user_id', $photo->user_id)
                ->where('type', $photo->type)
                ->where('id', '!=', $photo->id)
                ->orderBy('created_at', 'desc')
                ->first();
    
            if ($replacementPhoto) {
                $replacementPhoto->is_primary = true;
                $replacementPhoto->save();
            } else {
                Photo::where('user_id', $photo->user_id)
                    ->where('type', $photo->type)
                    ->update(['is_primary' => false]);
            }
        }
    
        Storage::delete($photo->image);
        $photo->delete();
        return response()->json(['success' => true, 'message' => 'Photo deleted successfully.']);
    }
    

    public function PhotoCover(Request $request): JsonResponse
    {
        $userId = $request->query('id', auth()->id()); 
        $photo = Photo::where('user_id', $userId)
                    ->where('type', 'cover')
                    ->where('is_primary', true)
                    ->first();
        
        if (!$photo) {
            $photo = Photo::where('user_id', $userId)
                        ->where('type', 'cover')
                        ->orderBy('created_at', 'desc')
                        ->first();
        }
    
        if ($photo) {
            $coverUrl = Storage::url($photo->image) . '?t=' . time(); 
            return response()->json(['success' => true, 'coverUrl' => $coverUrl]);
        } else {
            return response()->json(['success' => false, 'message' => 'No cover image found']);
        }
    }
    
    
    public function PhotoProfil(Request $request): JsonResponse
    {
        $userId = $request->query('id', auth()->id()); 
        $photo = Photo::where('user_id', $userId)
                    ->where('type', 'profil')
                    ->where('is_primary', true) 
                    ->first();

        if (!$photo) {
            $photo = Photo::where('user_id', $userId)
                        ->where('type', 'profil')
                        ->orderBy('created_at', 'desc')
                        ->first();
        }

        if ($photo) {
            $profilUrl = Storage::url($photo->image) . '?t=' . time(); 
            return response()->json(['success' => true, 'profilUrl' => $profilUrl]);
        } else {
            return response()->json(['success' => false, 'message' => 'No profile image found']);
        }
    }

}