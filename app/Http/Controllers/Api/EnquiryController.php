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
        try {
            $data = $request->validate([
                'guest_info' => 'nullable|array',
                'type'  => 'required|string|'.Rule::in(['rent', 'sale']),
                'book_id' => 'nullable|array',
                'book_id.*' => [
                    'integer'
                ],
                'user_id' => 'nullable|integer|exists:users,id',
                'items' => 'nullable|array',
                'status' => 'nullable|string',
                'notes' => 'nullable|string',
                'total_amount' => 'nullable|numeric',
                // if type is rent, then start_date and end_date are required
                'start_date' => 'required_if:type,rent|nullable|date',
                'end_date' => 'required_if:type,rent|nullable|date|after_or_equal:start_date',
                // return_date is optional, but if provided, must be a date after or equal to end_date
                'return_date' => 'nullable|date|after_or_equal:end_date',
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