@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Create Book</h2>
<div class="card">
  <form method="post" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div>
        <label>Title</label>
        <input class="input" type="text" name="title" value="{{ old('title') }}" required />
      </div>
      <div>
        <label>Author</label>
        <input class="input" type="text" name="author" value="{{ old('author') }}" required />
      </div>
      <div>
        <label>Category</label>
        <select name="category_id" class="input" required>
          <option value="">Select</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Status</label>
        <select name="status" class="input" required>
          <option value="available" @selected(old('status')=='available')>Available</option>
          <option value="unavailable" @selected(old('status')=='unavailable')>Unavailable</option>
        </select>
      </div>
      <div>
        <label>Price (Sale)</label>
        <input class="input" type="number" step="0.01" name="price_sale" value="{{ old('price_sale') }}" />
      </div>
      <div>
        <label>Price (Rent)</label>
        <input class="input" type="number" step="0.01" name="price_rent" value="{{ old('price_rent') }}" />
      </div>
      <div>
        <label>Stock</label>
        <input class="input" type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required />
      </div>
      <div>
        <label>Cover Image</label>
        <input class="input" type="file" name="cover" accept="image/*" />
      </div>
      <div style="grid-column:1/-1">
        <label>Description</label>
        <textarea class="input" name="description" rows="4">{{ old('description') }}</textarea>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Save</button>
      <a class="btn" href="{{ route('admin.books.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection