@extends('admin.layouts.app')

@section('content')
<div class="toolbar">
  <h2 style="margin:0">Sales</h2>
  <a class="btn primary" href="{{ route('admin.sales.create') }}">Create Sale</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Book</th>
        <th>User</th>
        <th>Status</th>
        <th>Amount</th>
        <th width="160"></th>
      </tr>
    </thead>
    <tbody>
    @foreach($sales as $s)
      <tr>
        <td>#{{ $s->id }}</td>
        <td>{{ optional($s->book)->title }}</td>
        <td>{{ optional($s->user)->name ?? 'Guest' }}</td>
        <td>{{ ucfirst($s->status) }}</td>
        <td>₹ {{ number_format($s->amount,2) }}</td>
        <td>
          <a class="btn" href="{{ route('admin.sales.edit',$s) }}">Edit</a>
          <a class="btn" href="{{ route('admin.sales.show',$s) }}">View</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div style="margin-top:10px">{{ $sales->links() }}</div>
@endsection