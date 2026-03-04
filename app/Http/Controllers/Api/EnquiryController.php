<?php

namespace App\Http\Controllers\Api;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        // return response()->json(['message' => 'Enquiry creation is currently disabled. Please contact support.','data' => $request->all()], 503);
        try {
            $data = $request->validate([
                'guest_info' => 'nullable|array',
                'type'  => 'required|string',
                'book_id' => 'nullable|array',
                'book_id.*' => [
                    'integer'
                ],
                'user_id' => 'nullable|integer|exists:users,id',
                'items' => 'nullable|array',
                'status' => 'nullable|string',
                'notes' => 'nullable|string',
                'total_amount' => 'nullable|numeric',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'return_date' => 'nullable|date',
            ]);
            if($request->user()){
                $data['user_id'] = $request->user()->id;
            } else {
                $data['user_id'] = $request->user_id ?? null;
            }
            $data['book_id'] = json_encode($data['book_id']);
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