<?php

namespace App\Http\Controllers\Computers;

use App\Http\Controllers\Controller;
use App\Models\PcBuild;
use App\Models\PcCategory;
use App\Models\PcComponent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PcBuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PcBuild::query()->userItems()->get();
        return Inertia::render('Computers/Builds/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PcCategory::query()->userItems()->with('components')->get();
        return Inertia::render('Computers/Builds/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'components' => 'required|array',
            'prime_cost' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        $build = auth()->user()->pcBuilds()->create([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'prime_cost' => $validated['prime_cost'],
            'sale_price' => $validated['sale_price'],
            'components' => json_encode($validated['components']), // вот здесь
        ]);

        return redirect()->route('pc-builds.index')->with('message', 'Сборка сохранена!');

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
        $build = PcBuild::query()->userItems()->findOrFail($id);
        $categories = PcCategory::query()->userItems()->with('components')->get();

        // Декодируем JSON компоненты для корректного отображения на фронте
        $build->components = json_decode($build->components);

        return Inertia::render('Computers/Builds/Edit', compact('build', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'components' => 'required|array',
            'prime_cost' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
        ]);

        $build = PcBuild::query()->userItems()->findOrFail($id);

        $build->update([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'prime_cost' => $validated['prime_cost'],
            'sale_price' => $validated['sale_price'],
            'components' => json_encode($validated['components']),
        ]);

        return redirect()->route('pc-builds.index')->with('message', 'Сборка успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PcBuild::query()->findOrFail($id)->delete();

        return redirect()->route('pc-builds.index')
            ->with('message', 'Сборка успешно удалена!');
    }
}
