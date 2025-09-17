<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'cover_url' => 'nullable|string', // allow direct URL
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // optional file upload (max ~5MB)
                'price_sale' => 'nullable|numeric',
                'price_rent' => 'nullable|numeric',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:available,unavailable',
            ]);

            // If a file was uploaded, store it and set cover_url
            if ($request->hasFile('cover')) {
                $path = $request->file('cover')->store('covers', 'public'); // storage/app/public/covers
                $data['cover_url'] = Storage::disk('public')->url($path);   // /storage/... (requires storage:link)
            }

            // Do not keep the UploadedFile itself in the data array
            unset($data['cover']);

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
                'cover_url' => 'nullable|string', // allow direct URL
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // optional file upload
                'price_sale' => 'nullable|numeric',
                'price_rent' => 'nullable|numeric',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:available,unavailable',
            ]);

            if ($request->hasFile('cover')) {
                $path = $request->file('cover')->store('covers', 'public');
                $data['cover_url'] = Storage::disk('public')->url($path);
            }

            unset($data['cover']);

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

    public function changestatus(Request $request)
    {
        try {
            $data = $request->validate([
                'book_id' => 'required|exists:books,id',
                'status' => 'required|in:available,unavailable',
            ]);
            $book = Book::findOrFail($data['book_id']);
            $book->update(['status' => $data['status']]);
            return $this->success($book, 'Book status updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function setBookOnSale(Request $request)
    {
        try {
            $data = $request->validate([
                'book_id' => 'required|exists:books,id',
                'is_sale' => 'required|integer|in:0,1',
            ]);
            $book = Book::findOrFail($data['book_id']);
            $book->update(['is_sale' => $data['is_sale']]);
            return $this->success($book, 'Book status updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function setBookOnRental(Request $request)
    {
        try {
            $data = $request->validate([
                'book_id' => 'required|exists:books,id',
                'is_rental' => 'required|integer|in:0,1',
            ]);
            $book = Book::findOrFail($data['book_id']);
            $book->update(['is_rental' => $data['is_rental']]);
            return $this->success($book, 'Book status updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function availableBooks()
    {
        try {
            $books = Book::available()->with('category')->orderByDesc('id')->get();
            return $this->success($books, 'Available books fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}