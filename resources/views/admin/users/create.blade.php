@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Create User</h2>
<div class="card">
  <form method="post" action="{{ route('admin.users.store') }}">
    @csrf
    <div class="row">
      <div>
        <label>Name</label>
        <input class="input" type="text" name="name" value="{{ old('name') }}" required />
      </div>
      <div>
        <label>Email</label>
        <input class="input" type="email" name="email" value="{{ old('email') }}" required />
      </div>
      <div>
        <label>Password</label>
        <input class="input" type="password" name="password" required />
      </div>
      <div>
        <label>Role</label>
        <select class="input" name="role" required>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div>
        <label>Phone</label>
        <input class="input" type="text" name="phone" value="{{ old('phone') }}" />
      </div>
      <div>
        <label>Address</label>
        <input class="input" type="text" name="address" value="{{ old('address') }}" />
      </div>

      <div>
        <label>Status</label>
        <select name="status" id="status">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="pending">Pending</option>
          <option value="block">Blocked</option>
        </select>
      </div>
    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Save</button>
      <a class="btn" href="{{ route('admin.users.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection