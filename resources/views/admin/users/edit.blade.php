@extends('admin.layouts.app')

@section('content')
<h2 style="margin:0 0 12px">Edit User</h2>
<div class="card">
  <form method="post" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')
    <div class="row">
      <div>
        <label>Name</label>
        <input class="input" type="text" name="name" value="{{ old('name', $user->name) }}" required />
      </div>
      <div>
        <label>Email</label>
        <input class="input" type="email" name="email" value="{{ old('email', $user->email) }}" required />
      </div>
      <div>
        <label>Password (leave blank to keep)</label>
        <input class="input" type="password" name="password" />
      </div>
      <div>
        <label>Role</label>
        <select class="input" name="role" required>
          <option value="user" @selected($user->hasRole('user'))>User</option>
          <option value="admin" @selected($user->hasRole('admin'))>Admin</option>
        </select>
      </div>
      <div>
        <label>Phone</label>
        <input class="input" type="text" name="phone" value="{{ old('phone', $user->phone) }}" />
      </div>
      <div>
        <label>Address</label>
        <input class="input" type="text" name="address" value="{{ old('address', $user->address) }}" />
      </div>

      <div>
        <label>Status</label>
        <select name="status" id="status">
          <option value="active" {{ old('status',$user->status)=='active'?'selected':'' }}  >Active</option>
          <option value="inactive" {{ old('status',$user->status)=='inactive'?'selected':'' }} >Inactive</option>
          <option value="pending" {{ old('status',$user->status)=='pending'?'selected':'' }} >Pending</option>
          <option value="block" {{ old('status',$user->status)=='block'?'selected':'' }} >Blocked</option>
        </select>
      </div>

    </div>
    <div style="margin-top:12px">
      <button class="btn primary">Update</button>
      <a class="btn" href="{{ route('admin.users.index') }}">Cancel</a>
    </div>
  </form>
</div>
@endsection