<?php

namespace App\Http\Controllers;

use App\Models\DeliveryLocation;
use Illuminate\Http\Request;

class DeliveryLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = DeliveryLocation::orderBy('name')->paginate(20);
        return view('delivery-locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('delivery-locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        DeliveryLocation::create($validated);

        return redirect()->route('delivery-locations.index')
            ->with('success', 'Локация добавлена успешно');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = DeliveryLocation::findOrFail($id);
        return view('delivery-locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = DeliveryLocation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $location->update($validated);

        return redirect()->route('delivery-locations.index')
            ->with('success', 'Локация обновлена успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = DeliveryLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('delivery-locations.index')
            ->with('success', 'Локация удалена успешно');
    }
}
