<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        return Rental::with(['book','user','enquiry'])->orderByDesc('id')->paginate(20);
    }

    public function show(Rental $rental)
    {
        return $rental->load(['book','user','enquiry']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'enquiry_id' => 'nullable|exists:enquiries,id',
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'amount' => 'required|numeric',
            'condition_notes' => 'nullable|string',
        ]);
        $rental = Rental::create($data);
        return response()->json($rental, 201);
    }

    public function markReturned(Request $request, Rental $rental)
    {
        $rental->markAsReturned($request->input('condition_notes'));
        return response()->json($rental);
    }

    public function stats()
    {
        return [
            'active' => Rental::where('status','active')->count(),
            'overdue' => Rental::where('status','active')->where('due_date','<', now())->count(),
            'total' => Rental::count(),
        ];
    }
}