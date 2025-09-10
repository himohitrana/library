<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Throwable;

class BookController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
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

            return $this->success($books, 'Books fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function show(Book $book)
    {
        try {
            return $this->success($book->load('category'), 'Book details', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request)
    {
        try {
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
            return $this->created($book, 'Book created');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function update(Request $request, Book $book)
    {
        try {
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
            return $this->success($book, 'Book updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return $this->success(null, 'Book deleted', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}