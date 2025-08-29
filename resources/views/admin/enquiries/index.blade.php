@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Enquiries</h2>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Status</th>
        <th>Total</th>
        <th width="160"></th>
      </tr>
    </thead>
    <tbody>
    @foreach($enquiries as $e)
      <tr>
        <td>#{{ $e->id }}</td>
        <td>{{ $e->customer_name }}</td>
        <td>{{ ucfirst($e->status) }}</td>
        <td>₹ {{ number_format($e->total_amount, 2) }}</td>
        <td>
          <a class="btn" href="{{ route('admin.enquiries.edit',$e) }}">Edit</a>
          <a class="btn" href="{{ route('admin.enquiries.show',$e) }}">View</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div style="margin-top:10px">{{ $enquiries->links() }}</div>
@endsection