<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Throwable;

class CartController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $userId = optional($request->user())->id;
            $guestId = $request->query('guest_id');

            $query = Cart::with('book');
            if ($userId) {
                $query->where('user_id', $userId);
            } elseif ($guestId) {
                $query->where('guest_id', $guestId);
            } else {
                return $this->success(['items' => [], 'total' => 0], 'Cart fetched', 200);
            }

            $items = $query->orderByDesc('id')->get();
            $total = $items->sum->total_price;
            return $this->success(['items' => $items, 'total' => $total], 'Cart fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request)
    {
        try {
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

            return $this->created($cart->load('book'), 'Cart item added');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function update(Request $request, Cart $cart)
    {
        try {
            $data = $request->validate([
                'rental_days' => 'nullable|integer|min:1',
                'quantity' => 'required|integer|min:1',
            ]);
            $cart->update($data);
            return $this->success($cart->load('book'), 'Cart item updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function destroy(Request $request, Cart $cart)
    {
        try {
            $cart->delete();
            return $this->success(null, 'Cart item deleted', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function clear(Request $request)
    {
        try {
            $userId = optional($request->user())->id;
            $guestId = $request->query('guest_id');

            $query = Cart::query();
            if ($userId) {
                $query->where('user_id', $userId);
            } elseif ($guestId) {
                $query->where('guest_id', $guestId);
            }
            $query->delete();

            return $this->success(null, 'Cart cleared', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}