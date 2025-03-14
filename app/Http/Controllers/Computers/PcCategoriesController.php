<?php

namespace App\Http\Controllers\Computers;

use App\Http\Controllers\Controller;
use App\Models\PcCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PcCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PcCategory::query()->userItems()->get();
        return Inertia::render('Computers/Categories/Index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Computers/Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new PcCategory();
        $category->user_id = auth()->user()->id;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('pc-categories.index')
            ->with('message', 'Категория успешно создана');
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
        $item = PcCategory::query()->findOrFail($id);

        return Inertia::render('Computers/Categories/Edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = PcCategory::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['name' => $validator->errors()->first('name')], 422);
        }

        $item->update([
            'name' => $request->name,
        ]);

        return redirect()->route('pc-categories.index')->with('success', 'Категория успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PcCategory::query()->findOrFail($id)->delete();

        return redirect()->route('pc-categories.index')->with('success', 'Категория успешно удалена!');
    }
}
