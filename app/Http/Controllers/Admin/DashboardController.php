<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Rental;
use App\Models\Sale;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'books_count' => Book::count(),
            'categories_count' => Category::count(),
            'users_count' => User::role('user')->count(),
            'enquiries_count' => Enquiry::count(),
            'pending_enquiries_count' => Enquiry::where('status', 'new')->count(),
            'active_rentals_count' => Rental::where('status', 'active')->count(),
            'overdue_rentals_count' => Rental::where('status', 'active')->where('due_date', '<', now())->count(),
            'total_sales' => Sale::where('status', 'completed')->sum('amount'),
            'total_rental_income' => Rental::where('status', '!=', 'cancelled')->sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}