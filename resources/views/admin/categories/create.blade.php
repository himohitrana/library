@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Create Category</h2>
<div class="card">
  <form method="post" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="row">
      <div>
        <label>Name</label>
        <input class="input" type="text" name="name" value="{{ old('name') }}" required />
      </div>
      <div style="grid-column:1/-1">
        <label>Description</label>
        <textarea class="input" name="description" rows="4">{{ old('description') }}</textarea>
      </div>
      <div>
        <label>Cover Image</label>
        <input class="input" type="file" name="image" accept="image/*" />
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Save</button>
      <a class="btn" href="{{ route('admin.categories.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection