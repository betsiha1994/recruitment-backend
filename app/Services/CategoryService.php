<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Get category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id)
    {
        return Category::find($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data)
    {
        return Category::create($data);
    }
}