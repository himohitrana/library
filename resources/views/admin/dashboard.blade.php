@extends('admin.layouts.app')

@section('content')
<div class="grid cols-3">
  <div class="stat">
    <div class="label">Books</div>
    <div class="value">{{ number_format($stats['books_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Categories</div>
    <div class="value">{{ number_format($stats['categories_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Users</div>
    <div class="value">{{ number_format($stats['users_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Enquiries</div>
    <div class="value">{{ number_format($stats['enquiries_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Pending Enquiries</div>
    <div class="value">{{ number_format($stats['pending_enquiries_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Active Rentals</div>
    <div class="value">{{ number_format($stats['active_rentals_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Overdue Rentals</div>
    <div class="value">{{ number_format($stats['overdue_rentals_count']) }}</div>
  </div>
  <div class="stat">
    <div class="label">Total Sales</div>
    <div class="value">₹ {{ number_format($stats['total_sales'], 2) }}</div>
  </div>
  <div class="stat">
    <div class="label">Rental Income</div>
    <div class="value">₹ {{ number_format($stats['total_rental_income'], 2) }}</div>
  </div>
</div>
@endsection