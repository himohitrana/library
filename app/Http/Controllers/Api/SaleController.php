<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return Sale::with(['book','user','enquiry'])->orderByDesc('id')->paginate(20);
    }

    public function show(Sale $sale)
    {
        return $sale->load(['book','user','enquiry']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'enquiry_id' => 'nullable|exists:enquiries,id',
            'user_id' => 'nullable|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);
        $sale = Sale::create($data);
        return response()->json($sale, 201);
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);
        $sale->update($data);
        return response()->json($sale);
    }

    public function stats()
    {
        return [
            'completed' => Sale::where('status','completed')->count(),
            'total_sales' => (float) Sale::where('status','completed')->sum('amount'),
        ];
    }
}