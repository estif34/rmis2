<?php

namespace App\Http\Controllers;

use App\Models\RiskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskCategoryController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = RiskCategory::withCount('risks')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:risk_categories',
            'description' => 'nullable',
        ]);
        
        RiskCategory::create($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(RiskCategory $category)
    {
        $category->load('risks.user');
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(RiskCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, RiskCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:risk_categories,name,' . $category->id,
            'description' => 'nullable',
        ]);
        
        $category->update($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(RiskCategory $category)
    {
        // Check if category has risks
        if ($category->risks()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with associated risks.');
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}