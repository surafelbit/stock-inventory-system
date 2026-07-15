<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // List all categories for the logged-in company
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::latest()->get()
        ]);
    }

    // Save a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // The company_id is automatically attached by our trait!
        Category::create($validated);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}