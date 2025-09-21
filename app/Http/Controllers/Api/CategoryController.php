<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends BaseApiController
{
    public function index()
    {
        try {
            $categories = Category::orderBy('name')->paginate(20);
            return $this->success($categories, 'Categories fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function show(Category $category)
    {
        try {
            return $this->success($category->loadCount('books'), 'Category details', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // optional file upload
                'description' => 'nullable|string',
            ]);
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('category', 'public');
                $data['image'] = Storage::disk('public')->url($path);
            }
            $category = Category::create($data);
            return $this->created($category, 'Category created');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // optional file upload
                'description' => 'nullable|string',
            ]);
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('category', 'public');
                $data['image'] = Storage::disk('public')->url($path);
            }
            $category->update($data);
            return $this->success($category, 'Category updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->success(null, 'Category deleted', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}