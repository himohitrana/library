<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::with('user')->orderByDesc('id')->paginate(15);
        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function edit(Enquiry $enquiry)
    {
        return view('admin.enquiries.edit', compact('enquiry'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);
        $enquiry->update($data);
        return redirect()->route('admin.enquiries.index')->with('status','Enquiry updated');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('status','Enquiry deleted');
    }
}