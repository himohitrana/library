<?php

namespace App\Http\Controllers\Api;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Throwable;

class EnquiryController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $enquiries = Enquiry::with('user')->orderByDesc('id')->paginate(20);
            return $this->success($enquiries, 'Enquiries fetched', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function show(Enquiry $enquiry)
    {
        try {
            return $this->success($enquiry->load('user'), 'Enquiry details', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'guest_info' => 'nullable|array',
                'type'  => 'required|string',
                'book_id' => 'nullable|integer|exists:books,id',
                'user_id' => 'nullable|integer|exists:users,id',
                'items' => 'nullable|array',
                'status' => 'nullable|string',
                'notes' => 'nullable|string',
                'total_amount' => 'nullable|numeric',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'return_date' => 'nullable|date',
            ]);
            $data['user_id'] = optional($request->user())->id;
            $enquiry = Enquiry::create($data);
            return $this->created($enquiry, 'Enquiry created');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        try {
            $data = $request->validate([
                'status' => 'required|string',
                'admin_notes' => 'nullable|string',
            ]);
            $enquiry->update($data);
            return $this->success($enquiry, 'Enquiry updated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}