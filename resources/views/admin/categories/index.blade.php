@extends('admin.layouts.app')

@section('content')
<div class="toolbar">
  <div></div>
  <a class="btn primary" href="{{ route('admin.categories.create') }}">Add Category</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th width="160"></th>
      </tr>
    </thead>
    <tbody>
    @forelse($categories as $category)
      <tr>
        <td>{{ $category->name }}</td>
        <td class="muted">{{ $category->description }}</td>
        <td>
          <a class="btn" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
          <form action="{{ route('admin.categories.destroy', $category) }}" method="post" style="display:inline" onsubmit="return confirm('Delete this category?')">
            @csrf
            @method('DELETE')
            <button class="btn danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="3" class="muted">No categories found.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:10px">{{ $categories->links() }}</div>
@endsection