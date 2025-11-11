<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $validated['image'] = $path;
        }

        Slider::create($validated);
        return redirect()->route('sliders.index')->with('success', 'Слайдер добавлен!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $slider = Slider::findOrFail($id);

        // If new image uploaded, delete old and store new
        if ($request->hasFile('image')) {
            // delete old
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $path = $request->file('image')->store('sliders', 'public');
            $validated['image'] = $path;
        }

        $slider->update($validated);
        return redirect()->route('sliders.index')->with('success', 'Слайдер обновлен!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        
        // Delete image file
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Слайдер удален!');
    }
}