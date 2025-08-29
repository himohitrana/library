<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = optional($request->user())->id;
        $guestId = $request->query('guest_id');

        $query = Cart::with('book');
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestId) {
            $query->where('guest_id', $guestId);
        } else {
            return response()->json([]);
        }

        $items = $query->orderByDesc('id')->get();
        $total = $items->sum->total_price;
        return compact('items','total');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'mode' => 'required|in:rent, sale, sale|rent,rent|sale,sale|rent',
            'rental_days' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'guest_id' => 'nullable|string',
        ]);

        $userId = optional($request->user())->id;
        $book = Book::findOrFail($data['book_id']);

        $cart = Cart::create([
            'user_id' => $userId,
            'guest_id' => $userId ? null : ($data['guest_id'] ?? null),
            'book_id' => $book->id,
            'mode' => str_contains($data['mode'], 'rent') ? 'rent' : 'sale',
            'rental_days' => $data['rental_days'] ?? null,
            'quantity' => $data['quantity'],
        ]);

        return response()->json($cart->load('book'), 201);
    }

    public function update(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'rental_days' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart->update($data);
        return response()->json($cart->load('book'));
    }

    public function destroy(Request $request, Cart $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function clear(Request $request)
    {
        $userId = optional($request->user())->id;
        $guestId = $request->query('guest_id');

        $query = Cart::query();
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($guestId) {
            $query->where('guest_id', $guestId);
        }
        $query->delete();

        return response()->json(['message' => 'Cleared']);
    }
}