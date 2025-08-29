@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Rental #{{ $rental->id }}</h2>
<div class="card">
  <div class="muted">Book: {{ optional($rental->book)->title }}</div>
  <div class="muted" style="margin-top:4px">User: {{ optional($rental->user)->name ?? 'Guest' }}</div>
  <div class="muted" style="margin-top:4px">Status: {{ ucfirst($rental->status) }}</div>
  <div class="muted" style="margin-top:4px">Start: {{ optional($rental->start_date)->format('Y-m-d') }}, Due: {{ optional($rental->due_date)->format('Y-m-d') }}</div>
  <div class="muted" style="margin-top:4px">Amount: ₹ {{ number_format($rental->amount,2) }}</div>
  <div class="muted" style="margin-top:8px">Notes: {{ $rental->condition_notes }}</div>
  <div style="margin-top:12px">
    <a class="btn" href="{{ route('admin.rentals.edit', $rental) }}">Edit</a>
    <a class="btn" href="{{ route('admin.rentals.index') }}">Back</a>
  </div>
</div>
@endsection