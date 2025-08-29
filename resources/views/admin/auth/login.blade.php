<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Admin Login</title>
  <style>
    :root{ --bg:#0b1020; --panel:#0e1428; --border:#1a2345; --text:#e8ecf7; --muted:#9aa7c7; --primary:#6ea8fe; --primary-2:#2563eb }
    body { background:radial-gradient(1200px 600px at 10% -10%, rgba(110,168,254,.12), transparent) , linear-gradient(180deg,#0b1020,#0a1229); color:var(--text); font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin:0; display:grid; place-items:center; min-height:100vh }
    .card { width:380px; background:linear-gradient(180deg,#0f1733,#0b132a); border:1px solid var(--border); border-radius:14px; padding:20px; box-shadow: 0 10px 30px rgba(0,0,0,.25) }
    h2{margin:0 0 6px; font-weight:800}
    .sub{color:var(--muted); margin-bottom:12px}
    label { display:block; margin-top:10px; color:#c9cfe1 }
    input { width:100%; padding:10px 12px; border-radius:10px; background:#0a1230; border:1px solid var(--border); color:#e6e9f2 }
    .btn { width:100%; margin-top:16px; background:linear-gradient(180deg,var(--primary),var(--primary-2)); color:#fff; border:1px solid #1d4ed8; padding:10px; border-radius:10px; cursor:pointer; font-weight:700 }
    .error { color:#fecaca; margin-top:8px; font-size:.9rem }
  </style>
</head>
<body>
  <div class="card">
    <h2>Welcome back</h2>
    <div class="sub">Sign in to access the admin dashboard</div>
    @if($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="post" action="{{ route('admin.login') }}">
      @csrf
      <label>Email</label>
      <input type="email" name="email" required autocomplete="email"/>
      <label>Password</label>
      <input type="password" name="password" required autocomplete="current-password"/>
      <button class="btn">Sign in</button>
    </form>
  </div>
</body>
</html>