<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Get all jobs for a specific category
     *
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function jobs($categoryId)
{
    // Find category with jobs
    $category = Category::with('jobs')->find($categoryId);

    if (!$category) {
        return response()->json([
            'error' => 'Category not found'
        ], 404);
    }

    // Return only the jobs array
    return response()->json($category->jobs);
}

    /**
     * Create a new category
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json($category, 201);
    }

    /**
     * Optional: Update a category
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        $category->update(['name' => $request->name]);

        return response()->json($category);
    }

    /**
     * Optional: Delete a category
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}