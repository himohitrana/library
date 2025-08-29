@extends('admin.layouts.app')

@section('content')
<div class="toolbar">
  <form method="get">
    <input class="input" type="search" name="q" value="{{ $q }}" placeholder="Search books..." style="width:280px"/>
  </form>
  <a class="btn primary" href="{{ route('admin.books.create') }}">Add Book</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Status</th>
        <th>Stock</th>
        <th width="160"></th>
      </tr>
    </thead>
    <tbody>
    @forelse($books as $book)
      <tr>
        <td>{{ $book->title }}</td>
        <td>{{ $book->author }}</td>
        <td>{{ optional($book->category)->name }}</td>
        <td>{{ ucfirst($book->status) }}</td>
        <td>{{ $book->stock }}</td>
        <td>
          <a class="btn" href="{{ route('admin.books.edit', $book) }}">Edit</a>
          <form action="{{ route('admin.books.destroy', $book) }}" method="post" style="display:inline" onsubmit="return confirm('Delete this book?')">
            @csrf
            @method('DELETE')
            <button class="btn danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="muted">No books found.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $books->withQueryString()->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection