<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['book','user'])->orderByDesc('id')->paginate(15);
        return view('admin.sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }

    public function create()
    {
        $books = Book::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.sales.create', compact('books','users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);
        Sale::create($data);
        return redirect()->route('admin.sales.index')->with('status','Sale created');
    }

    public function edit(Sale $sale)
    {
        $books = Book::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.sales.edit', compact('sale','books','users'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);
        $sale->update($data);
        return redirect()->route('admin.sales.index')->with('status','Sale updated');
    }
}