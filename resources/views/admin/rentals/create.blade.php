@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Create Rental</h2>
<div class="card">
  <form method="post" action="{{ route('admin.rentals.store') }}">
    @csrf
    <div class="row">
      <div>
        <label>User</label>
        <select class="input" name="user_id">
          <option value="">Guest</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Book</label>
        <select class="input" name="book_id" required>
          @foreach($books as $b)
            <option value="{{ $b->id }}">{{ $b->title }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Status</label>
        <select class="input" name="status" required>
          @foreach(['active','returned','cancelled'] as $s)
            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Amount</label>
        <input class="input" type="number" step="0.01" name="amount" required />
      </div>
      <div>
        <label>Start Date</label>
        <input class="input" type="date" name="start_date" required />
      </div>
      <div>
        <label>Due Date</label>
        <input class="input" type="date" name="due_date" required />
      </div>
      <div style="grid-column:1/-1">
        <label>Condition Notes</label>
        <textarea class="input" name="condition_notes" rows="3"></textarea>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Save</button>
      <a class="btn" href="{{ route('admin.rentals.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection