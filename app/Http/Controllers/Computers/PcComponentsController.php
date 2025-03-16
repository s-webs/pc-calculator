<?php

namespace App\Http\Controllers\Computers;

use App\Http\Controllers\Controller;
use App\Models\PcCategory;
use App\Models\PcComponent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Laravel\Prompts\alert;

class PcComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PcComponent::query()->userItems()->get();
        return Inertia::render('Computers/Components/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PcCategory::query()->userItems()->get();

        return Inertia::render('Computers/Components/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new PcComponent();
        $item->user_id = auth()->user()->id;
        $item->pc_category_id = $request->pc_category_id;
        $item->image = $request->image ?? null;
        $item->name = $request->name;
        $item->prime_cost = $request->prime_cost;
        $item->sale_price  = $request->sale_price ?? null;
        $item->quantity  = $request->quantity ?? null;
        $item->available  = $request->available ?? null;
        $item->save();

        return redirect()->route('pc-components.index')->with('message', 'Компонент успешно создан!');
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
        $component = PcComponent::query()->findOrFail($id);
        $categories = PcCategory::query()->userItems()->get();
        return Inertia::render('Computers/Components/Edit', compact('component', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pc_category_id' => 'required|exists:pc_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|string',
            'prime_cost' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'available' => 'boolean',
        ]);

        $item = PcComponent::query()->findOrFail($id);

        $item->update([
            'pc_category_id' => $request->pc_category_id,
            'name' => $request->name,
            'image' => $request->image ?? null,
            'prime_cost' => $request->prime_cost,
            'sale_price' => $request->sale_price ?? null,
            'quantity' => $request->quantity ?? null,
            'available' => $request->available ?? false,
        ]);

        return redirect()->route('pc-components.index')->with('message', 'Компонент успешно обновлен!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PcComponent::query()->findOrFail($id)->delete();

        return redirect()->route('pc-components.index')
            ->with('message', 'Компонент успешно удален!');
    }
}
