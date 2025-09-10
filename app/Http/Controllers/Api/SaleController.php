<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use Illuminate\Http\Request;
use Throwable;

class SaleController extends BaseApiController
{
    public function index()
    {
        try {
            $sales = Sale::with(['book','user','enquiry'])->orderByDesc('id')->paginate(20);
            return $this->success($sales, 'Sales fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function show(Sale $sale)
    {
        try {
            return $this->success($sale->load(['book','user','enquiry']), 'Sale details', 200);
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
                'status' => 'required|string',
                'amount' => 'required|numeric',
            ]);
            $sale = Sale::create($data);
            return $this->created($sale, 'Sale created');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function update(Request $request, Sale $sale)
    {
        try {
            $data = $request->validate([
                'status' => 'required|string',
                'amount' => 'required|numeric',
            ]);
            $sale->update($data);
            return $this->success($sale, 'Sale updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function stats()
    {
        try {
            $stats = [
                'completed' => Sale::where('status','completed')->count(),
                'total_sales' => (float) Sale::where('status','completed')->sum('amount'),
            ];
            return $this->success($stats, 'Sales stats', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}