<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['book','user'])->orderByDesc('id')->paginate(15);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        return view('admin.rentals.show', compact('rental'));
    }

    public function create()
    {
        $books = Book::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.rentals.create', compact('books','users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'amount' => 'required|numeric',
            'condition_notes' => 'nullable|string',
        ]);
        Rental::create($data);
        return redirect()->route('admin.rentals.index')->with('status','Rental created');
    }

    public function edit(Rental $rental)
    {
        $books = Book::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.rentals.edit', compact('rental','books','users'));
    }

    public function update(Request $request, Rental $rental)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'amount' => 'required|numeric',
            'condition_notes' => 'nullable|string',
        ]);
        $rental->update($data);
        return redirect()->route('admin.rentals.index')->with('status','Rental updated');
    }
}