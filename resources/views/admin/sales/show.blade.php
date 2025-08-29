@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Sale #{{ $sale->id }}</h2>
<div class="card">
  <div class="muted">Book: {{ optional($sale->book)->title }}</div>
  <div class="muted" style="margin-top:4px">User: {{ optional($sale->user)->name ?? 'Guest' }}</div>
  <div class="muted" style="margin-top:4px">Status: {{ ucfirst($sale->status) }}</div>
  <div class="muted" style="margin-top:4px">Amount: ₹ {{ number_format($sale->amount,2) }}</div>
  <div style="margin-top:12px">
    <a class="btn" href="{{ route('admin.sales.edit', $sale) }}">Edit</a>
    <a class="btn" href="{{ route('admin.sales.index') }}">Back</a>
  </div>
</div>
@endsection