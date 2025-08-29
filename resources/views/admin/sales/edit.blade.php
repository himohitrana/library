@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Edit Sale #{{ $sale->id }}</h2>
<div class="card">
  <form method="post" action="{{ route('admin.sales.update', $sale) }}">
    @csrf
    @method('PUT')
    <div class="row">
      <div>
        <label>User</label>
        <select class="input" name="user_id">
          <option value="">Guest</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" @selected(old('user_id',$sale->user_id)==$u->id)>{{ $u->name }} ({{ $u->email }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Book</label>
        <select class="input" name="book_id" required>
          @foreach($books as $b)
            <option value="{{ $b->id }}" @selected(old('book_id',$sale->book_id)==$b->id)>{{ $b->title }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Status</label>
        <select class="input" name="status" required>
          @foreach(['pending','completed','cancelled'] as $s)
            <option value="{{ $s }}" @selected(old('status',$sale->status)==$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Amount</label>
        <input class="input" type="number" step="0.01" name="amount" value="{{ old('amount',$sale->amount) }}" required />
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Update</button>
      <a class="btn" href="{{ route('admin.sales.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection