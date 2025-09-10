<?php

namespace App\Http\Controllers\Api;

use App\Models\Rental;
use Illuminate\Http\Request;
use Throwable;

class RentalController extends BaseApiController
{
    public function index()
    {
        try {
            $rentals = Rental::with(['book','user','enquiry'])->orderByDesc('id')->paginate(20);
            return $this->success($rentals, 'Rentals fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function show(Rental $rental)
    {
        try {
            return $this->success($rental->load(['book','user','enquiry']), 'Rental details', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request)
    {
        try {
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
            return $this->created($rental, 'Rental created');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function markReturned(Request $request, Rental $rental)
    {
        try {
            $rental->markAsReturned($request->input('condition_notes'));
            return $this->success($rental, 'Rental marked as returned', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function stats()
    {
        try {
            $stats = [
                'active' => Rental::where('status','active')->count(),
                'overdue' => Rental::where('status','active')->where('due_date','<', now())->count(),
                'total' => Rental::count(),
            ];
            return $this->success($stats, 'Rental stats', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}