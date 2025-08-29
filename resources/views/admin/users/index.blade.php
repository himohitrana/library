@extends('admin.layouts.app')

@section('content')
<div class="toolbar">
  <div></div>
  <a class="btn primary" href="{{ route('admin.users.create') }}">Add User</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
        <td><a class="btn" href="{{ route('admin.users.edit', $user) }}">Edit</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div style="margin-top:10px">{{ $users->links() }}</div>
@endsection