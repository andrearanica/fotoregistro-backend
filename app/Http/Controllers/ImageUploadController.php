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
        if ($user->photo) {
            return response()->json('images/' . $user->photo);
        }
        return response()->json(['message' => 'user does not have a photo']);
    }

    public function delete (Request $request, string $id) {
        if ($user = User::find($id)) {
            if (!$user->photo) {
                return response()->json(['message' => 'user does not have a photo']);
            }
            unlink(public_path('images/' . $user->photo));
            $user->update(['photo' => null]);
            return response()->json(['message' => 'photo deleted']);
        } else {
            return response()->json(['message' => 'user not found']);
        }
    }
}
