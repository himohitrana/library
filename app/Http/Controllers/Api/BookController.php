<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');

        $books = Book::query()
            ->when($q, fn($query) => $query->search($q))
            ->when($categoryId, fn($query) => $query->byCategory($categoryId))
            ->when($status, fn($query) => $query->byStatus($status))
            ->with('category')
            ->orderByDesc('id')
            ->paginate(20);

        return $books;
    }

    public function show(Book $book)
    {
        return $book->load('category');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|string',
            'price_sale' => 'nullable|numeric',
            'price_rent' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        $book = Book::create($data);
        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|string',
            'price_sale' => 'nullable|numeric',
            'price_rent' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);
        $book->update($data);
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Deleted']);
    }
}