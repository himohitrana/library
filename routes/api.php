<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\RentalController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

// Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
});

// Books
Route::get('books', [BookController::class, 'index']);
Route::get('books/{book}', [BookController::class, 'show']);
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('books', [BookController::class, 'store']);
    Route::post('book/set/on/sale', [BookController::class, 'setBookOnSale']);
    Route::post('book/set/on/rental', [BookController::class, 'setBookOnRental']);
    Route::post('book/status/change', [BookController::class, 'changestatus']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::delete('books/{book}', [BookController::class, 'destroy']);
});

// Wishlist (authenticated users only)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{book}', [WishlistController::class, 'store']);
    Route::delete('wishlist/{book}', [WishlistController::class, 'destroy']);
    Route::get('wishlist/{book}/check', [WishlistController::class, 'check']);
});

// Cart (supports both authenticated and guest users)
Route::get('cart', [CartController::class, 'index']);
Route::post('cart', [CartController::class, 'store']);
Route::put('cart/{cart}', [CartController::class, 'update']);
Route::delete('cart/{cart}', [CartController::class, 'destroy']);
Route::delete('cart', [CartController::class, 'clear']);

// Enquiries
Route::post('enquiries', [EnquiryController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('enquiries', [EnquiryController::class, 'index']);
    Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show']);
    
    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::put('enquiries/{enquiry}', [EnquiryController::class, 'update']);
    });
});

// Rentals
Route::middleware('auth:sanctum')->group(function () {
    Route::get('rentals', [RentalController::class, 'index']);
    Route::get('rentals/{rental}', [RentalController::class, 'show']);
    
    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::post('rentals', [RentalController::class, 'store']);
        Route::put('rentals/{rental}/return', [RentalController::class, 'markReturned']);
        Route::get('rentals/stats', [RentalController::class, 'stats']);
    });
});

// Sales (admin only)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('sales', [SaleController::class, 'index']);
    Route::get('sales/{sale}', [SaleController::class, 'show']);
    Route::put('sales/{sale}', [SaleController::class, 'update']);
    Route::get('sales/stats', [SaleController::class, 'stats']);
});

// Dashboard stats (admin only)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('dashboard/stats', function () {
        return response()->json([
            'books_count' => \App\Models\Book::count(),
            'categories_count' => \App\Models\Category::count(),
            'users_count' => \App\Models\User::role('user')->count(),
            'enquiries_count' => \App\Models\Enquiry::count(),
            'pending_enquiries_count' => \App\Models\Enquiry::where('status', 'new')->count(),
            'active_rentals_count' => \App\Models\Rental::where('status', 'active')->count(),
            'overdue_rentals_count' => \App\Models\Rental::where('status', 'active')
                ->where('due_date', '<', now())->count(),
            'total_sales_count' => \App\Models\Sale::where('status', 'completed')->count(),
            'total_sales' => \App\Models\Sale::where('status', 'completed')->sum('amount'),
            'total_rental_income' => \App\Models\Rental::where('status', '!=', 'cancelled')->sum('amount'),
        ]);
    });
});