<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $books = Book::when($q, fn($query) => $query->search($q))
            ->with('category')
            ->orderByDesc('id')
            ->paginate(12);

        return view('admin.books.index', compact('books','q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'cover_url' => 'nullable|string',
            'price_sale' => 'nullable|numeric',
            'price_rent' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover_url'] = $path; // stored path, accessor will expand
        }

        Book::create($data);
        return redirect()->route('admin.books.index')->with('status','Book created');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book','categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'cover_url' => 'nullable|string',
            'price_sale' => 'nullable|numeric',
            'price_rent' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover_url'] = $path;
        }

        $book->update($data);
        return redirect()->route('admin.books.index')->with('status','Book updated');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('status','Book deleted');
    }
}