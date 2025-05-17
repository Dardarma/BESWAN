<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function imageUploadArticle(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/article', $imageName);

            return response()->json(['location' => asset('storage/article/' . $imageName)]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function deleteImage(Request $request)
    {
        $request->headers->set('Accept', 'application/json');

        $request->validate([
            'image_url' => 'required|string'
        ]);

        $imagePath = str_replace(asset('storage/'), '', $request->image_url);
        $fullPath = storage_path('app/public/' . $imagePath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['message' => 'Gambar berhasil dihapus']);
        }

        return response()->json(['message' => 'Gambar tidak ditemukan'], 404);
    }
}
