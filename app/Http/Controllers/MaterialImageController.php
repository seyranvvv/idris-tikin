<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;

class MaterialImageController extends Controller
{
    public function store(Request $request, $material_id)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $material = Material::on('sqlsrv')->findOrFail($material_id);
        foreach ($request->file('images', []) as $file) {
            $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
            $path = "materials/{$material_id}/$filename";
                // Resize and save with Spatie
                $file->storeAs("materials/{$material_id}", $filename, 'public');
                $fullPath = Storage::disk('public')->path($path);
                Image::load($fullPath)->width(480)->height(480)->save();
            ProductImage::on('pgsql')->create([
                'material_id' => $material_id,
                'image_path' => $path,
            ]);
        }
        return back()->with('success', 'Изображения успешно загружены!');
    }

    public function destroy($material_id, $image_id)
    {
        $image = ProductImage::on('pgsql')->where('material_id', $material_id)->findOrFail($image_id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Изображение удалено!');
    }

    public function update(Request $request, $material_id, $image_id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $image = ProductImage::on('pgsql')->where('material_id', $material_id)->findOrFail($image_id);
        // Remove old file
        Storage::disk('public')->delete($image->image_path);
        // Save new file
        $file = $request->file('image');
        $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $path = "materials/{$material_id}/$filename";
        $file->storeAs("materials/{$material_id}", $filename, 'public');
        $fullPath = Storage::disk('public')->path($path);
        Image::load($fullPath)->width(480)->height(480)->save();
        $image->image_path = $path;
        $image->save();
        return back()->with('success', 'Изображение обновлено!');
    }
}
