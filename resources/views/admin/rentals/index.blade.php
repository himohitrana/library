@extends('admin.layouts.app')

@section('content')
<div class="toolbar">
  <h2 style="margin:0">Rentals</h2>
  <a class="btn primary" href="{{ route('admin.rentals.create') }}">Create Rental</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Book</th>
        <th>User</th>
        <th>Status</th>
        <th>Start</th>
        <th>Due</th>
        <th>Amount</th>
        <th width="160"></th>
      </tr>
    </thead>
    <tbody>
    @foreach($rentals as $r)
      <tr>
        <td>#{{ $r->id }}</td>
        <td>{{ optional($r->book)->title }}</td>
        <td>{{ optional($r->user)->name ?? 'Guest' }}</td>
        <td>{{ ucfirst($r->status) }}</td>
        <td>{{ optional($r->start_date)->format('Y-m-d') }}</td>
        <td>{{ optional($r->due_date)->format('Y-m-d') }}</td>
        <td>₹ {{ number_format($r->amount,2) }}</td>
        <td>
          <a class="btn" href="{{ route('admin.rentals.edit',$r) }}">Edit</a>
          <a class="btn" href="{{ route('admin.rentals.show',$r) }}">View</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div style="margin-top:10px">{{ $rentals->links() }}</div>
@endsection