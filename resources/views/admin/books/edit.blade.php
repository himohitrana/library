@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Edit Book</h2>
<div class="card">
  <form method="post" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <div>
        <label>Title</label>
        <input class="input" type="text" name="title" value="{{ old('title', $book->title) }}" required />
      </div>
      <div>
        <label>Author</label>
        <input class="input" type="text" name="author" value="{{ old('author', $book->author) }}" required />
      </div>
      <div>
        <label>Category</label>
        <select name="category_id" class="input" required>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id', $book->category_id)==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Status</label>
        <select name="status" class="input" required>
          <option value="available" @selected(old('status',$book->status)=='available')>Available</option>
          <option value="unavailable" @selected(old('status',$book->status)=='unavailable')>Unavailable</option>
        </select>
      </div>
      <div>
        <label>Price (Sale)</label>
        <input class="input" type="number" step="0.01" name="price_sale" value="{{ old('price_sale', $book->price_sale) }}" />
      </div>
      <div>
        <label>Price (Rent)</label>
        <input class="input" type="number" step="0.01" name="price_rent" value="{{ old('price_rent', $book->price_rent) }}" />
      </div>
      <div>
        <label>Stock</label>
        <input class="input" type="number" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required />
      </div>
      <div>
        <label>Cover Image</label>
        <input class="input" type="file" name="cover" accept="image/*" />
        @if($book->cover_url)
          <div class="muted" style="margin-top:6px">Current: <a href="{{ $book->cover_url }}" target="_blank">View</a></div>
        @endif
      </div>
      <div style="grid-column:1/-1">
        <label>Description</label>
        <textarea class="input" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Update</button>
      <a class="btn" href="{{ route('admin.books.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection