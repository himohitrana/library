@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Edit Category</h2>
<div class="card">
  <form method="post" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')
    <div class="row">
      <div>
        <label>Name</label>
        <input class="input" type="text" name="name" value="{{ old('name', $category->name) }}" required />
      </div>
      <div style="grid-column:1/-1">
        <label>Description</label>
        <textarea class="input" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Update</button>
      <a class="btn" href="{{ route('admin.categories.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection