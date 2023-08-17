<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use App\Models\User;
use Storage;

class ImageUploadController extends Controller
{
    /**
     * Store the uploaded image
     */
    public function storeImage (Request $request, string $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $imageName = $id . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $user = User::find($id);
        $user->update(['photo' => $imageName]);

        return response()->json(['message' => 'image uploaded'], 201);
    }

    /**
     * Return the path of the user's photo from public
     */
    public function getImage (Request $request, string $id)
    {
        $user = User::find($id);
        return response()->json('images/' . $user->photo);
    }
}
