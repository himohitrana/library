<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Throwable;

class WishlistController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $items = Wishlist::with('book')->where('user_id', $user->id)->orderByDesc('id')->get();
            return $this->success($items, 'Wishlist fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request, Book $book)
    {
        try {
            $user = $request->user();
            $exists = Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->exists();
            if (! $exists) {
                Wishlist::create(['user_id' => $user->id, 'book_id' => $book->id]);
            }
            return $this->created(null, 'Added to wishlist');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function destroy(Request $request, Book $book)
    {
        try {
            $user = $request->user();
            Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->delete();
            return $this->success(null, 'Removed from wishlist', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function check(Request $request, Book $book)
    {
        try {
            $user = $request->user();
            $exists = Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->exists();
            return $this->success(['exists' => $exists], 'Wishlist check', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}