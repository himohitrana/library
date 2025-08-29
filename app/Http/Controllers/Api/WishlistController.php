<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $items = Wishlist::with('book')->where('user_id', $user->id)->orderByDesc('id')->get();
        return $items;
    }

    public function store(Request $request, Book $book)
    {
        $user = $request->user();
        $exists = Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->exists();
        if (! $exists) {
            Wishlist::create(['user_id' => $user->id, 'book_id' => $book->id]);
        }
        return response()->json(['message' => 'Added to wishlist']);
    }

    public function destroy(Request $request, Book $book)
    {
        $user = $request->user();
        Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->delete();
        return response()->json(['message' => 'Removed from wishlist']);
    }

    public function check(Request $request, Book $book)
    {
        $user = $request->user();
        $exists = Wishlist::where('user_id', $user->id)->where('book_id', $book->id)->exists();
        return ['exists' => $exists];
    }
}