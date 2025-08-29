<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $enquiries = Enquiry::with('user')->orderByDesc('id')->paginate(20);
        return $enquiries;
    }

    public function show(Enquiry $enquiry)
    {
        return $enquiry->load('user');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guest_info' => 'nullable|array',
            'items' => 'required|array',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'total_amount' => 'nullable|numeric',
        ]);
        $data['user_id'] = optional($request->user())->id;
        $enquiry = Enquiry::create($data);
        return response()->json($enquiry, 201);
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);
        $enquiry->update($data);
        return response()->json($enquiry);
    }
}