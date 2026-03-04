@extends('admin.layouts.app')

@section('content')

@if($enquiry)
  @php
      $bookIds = json_decode($enquiry->book_id, true);
      $books = App\Models\Book::whereIn('id', $bookIds)->get() ?? [];
      $totalAmount = $books->sum(function($book) use ($enquiry) {
        if($enquiry->type === 'sale') {
          return $book->price_sale ?? 0;
        } elseif($enquiry->type === 'rent') {
          return $book->price_rent ?? 0;
        }
      });
    @endphp
  <h2 style="margin:0 0 12px">Enquiry #{{ $enquiry->id }}</h2>
  <p>Enquiry Date:- {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y') }}</p>
<div class="card">
  <div class="muted">Customer: {{ $enquiry->customer_name }} ({{ $enquiry->customer_email ?? 'N/A' }})</div>
  <div class="muted" style="margin-top:4px">Status: {{ ucfirst($enquiry->status) }}</div>
  <div class="muted" style="margin-top:4px">Type: {{ ucfirst($enquiry->type) }}</div>
  @if($enquiry->type == 'rent')
    <div class="muted" style="margin-top:4px">Rent Start Date: {{ \Carbon\Carbon::parse($enquiry->start_date)->format('d M Y') }}</div> - <div class="muted" style="margin-top:4px">Rent End Date: {{ \Carbon\Carbon::parse($enquiry->end_date)->format('d M Y') }}</div>
    <div class="muted" style="margin-top:4px">Rent Duration: {{ \Carbon\Carbon::parse($enquiry->start_date)->diffInDays(\Carbon\Carbon::parse($enquiry->end_date)) }} days</div>
    <div class="muted" style="margin-top:4px">Return Date: {{ \Carbon\Carbon::parse($enquiry->return_date)->format('d M Y') }}</div>
  @endif
  <div class="muted" style="margin-top:4px">Total: ₹ {{ number_format($totalAmount,2) }}</div>
  <div class="muted" style="margin-top:8px">Notes: {{ $enquiry->notes }}</div>
  <div class="muted" style="margin-top:8px">Admin Notes: {{ $enquiry->admin_notes }}</div>
  <div style="margin-top:8px">
    
    <table>
      <tr>
        <th>Book Title</th>
        <th>Author</th>
        <th>Price Sale</th>
        <th>Price Rent</th>
      </tr>
    @foreach ($books as $book)
      <tr>
        <td>{{ $book->title ?? 'Unknown Book' }}</td>
        <td>{{ $book->author ?? 'Unknown Author' }}</td>
        <td>₹ {{ number_format($book->price_sale ?? 0,2) }}</td>
        <td>₹ {{ number_format($book->price_rent ?? 0,2) }}</td>
      </tr>
    @endforeach
    </table>

  </div>
  
  <div style="margin-top:12px">
    <a class="btn" href="{{ route('admin.enquiries.edit', $enquiry) }}">Edit</a>
    <a class="btn" href="{{ route('admin.enquiries.index') }}">Back</a>
  </div>
</div>
@else
  <p>Enquiry not found.</p>
@endif
@endsection