<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        ]);
        $path = $request->file('image')->store('photos');
        $photo = new Photo();
        $photo->user_id = auth()->user()->id;
        $photo->description = $request->input('description'); 
        $photo->image = $path;
        $photo->save();
        return response()->json(['success' => true, 'message' => 'Image uploaded successfully.']);
    }


    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Storage::delete($photo->image);
        $path = $request->file('image')->store('photos');
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
}
