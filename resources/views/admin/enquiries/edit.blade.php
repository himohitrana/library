@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Edit Enquiry #{{ $enquiry->id }}</h2>
<div class="card">
  <form method="post" action="{{ route('admin.enquiries.update', $enquiry) }}">
    @csrf
    @method('PUT')
    <div class="row">
      <div>
        <label>Status</label>
        <select class="input" name="status" required>
          @foreach(['new','processing','completed','cancelled'] as $s)
            <option value="{{ $s }}" @selected(old('status',$enquiry->status)===$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div style="grid-column:1/-1">
        <label>Admin Notes</label>
        <textarea class="input" name="admin_notes" rows="4">{{ old('admin_notes', $enquiry->admin_notes) }}</textarea>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Update</button>
      <a class="btn" href="{{ route('admin.enquiries.index') }}">Back</a>
    </div>
  </form>
</div>
@endsection