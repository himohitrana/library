@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Enquiry #{{ $enquiry->id }}</h2>
<div class="card">
  <div class="muted">Customer: {{ $enquiry->customer_name }} ({{ $enquiry->customer_email ?? 'N/A' }})</div>
  <div class="muted" style="margin-top:4px">Status: {{ ucfirst($enquiry->status) }}</div>
  <div class="muted" style="margin-top:4px">Total: ₹ {{ number_format($enquiry->total_amount,2) }}</div>
  <div style="margin-top:8px">
    <pre style="white-space:pre-wrap">{{ json_encode($enquiry->items, JSON_PRETTY_PRINT) }}</pre>
  </div>
  <div class="muted" style="margin-top:8px">Notes: {{ $enquiry->notes }}</div>
  <div class="muted" style="margin-top:8px">Admin Notes: {{ $enquiry->admin_notes }}</div>
  <div style="margin-top:12px">
    <a class="btn" href="{{ route('admin.enquiries.edit', $enquiry) }}">Edit</a>
    <a class="btn" href="{{ route('admin.enquiries.index') }}">Back</a>
  </div>
</div>
@endsection