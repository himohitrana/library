<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin</title>
  <style>
    :root{
      --bg:#0b1020; --panel:#0e1428; --panel-2:#0f1733; --border:#1a2345; --muted:#8b93a7; --text:#e8ecf7; --primary:#6ea8fe; --primary-2:#2563eb; --accent:#22d3ee; --danger:#ef4444;
      --ring: 0 0 0 3px rgba(37,99,235,.35);
    }
    *{box-sizing:border-box}
    body{margin:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; background:linear-gradient(180deg,#0b1020 0%,#0a1229 100%); color:var(--text);}

    .layout{display:grid; grid-template-columns: 240px 1fr; min-height:100vh}
    .sidebar{background:linear-gradient(180deg,#0e1428 0,#0b132a 100%); border-right:1px solid var(--border); padding:18px 14px; position:sticky; top:0; height:100vh}
    .brand{display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:.4px; margin-bottom:16px}
    .brand .dot{width:10px; height:10px; border-radius:999px; background:conic-gradient(from 180deg, var(--accent), var(--primary)); box-shadow:0 0 0 6px rgba(34,211,238,.12)}
    .search{position:relative; margin:10px 0 18px}
    .search input{width:100%; padding:10px 12px; padding-left:34px; border-radius:10px; background:#0a1230; border:1px solid var(--border); color:var(--text)}
    .search .icon{position:absolute; left:10px; top:50%; transform:translateY(-50%); opacity:.65}
    .nav a{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#c9d2eb; text-decoration:none; border:1px solid transparent}
    .nav a.active{background:linear-gradient(90deg,#0f1733,#0a1230); border-color:var(--border); color:#eaf1ff; box-shadow:var(--ring)}
    .nav a:hover{background:#0f1733; border-color:var(--border)}
    .nav .section{margin-top:12px; margin-bottom:6px; color:var(--muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08rem}

    .top{display:flex; align-items:center; justify-content:space-between; padding:14px 18px; border-bottom:1px solid var(--border); background:rgba(14,20,40,.6); backdrop-filter: blur(8px); position:sticky; top:0; z-index:10}
    .user-actions form{display:inline}
    .btn{display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px; border:1px solid #293154; background:#111936; color:#e6e9f2; cursor:pointer}
    .btn.primary{background:linear-gradient(180deg,var(--primary),var(--primary-2)); border-color:#1d4ed8; color:#fff}
    .btn.danger{background:linear-gradient(180deg,#ef4444,#b91c1c); border-color:#7f1d1d; color:#fff}

    .container{max-width:1200px; margin: 22px auto; padding: 0 20px}
    .card{background:linear-gradient(180deg,#0f1733,#0b132a); border:1px solid var(--border); border-radius:14px; padding:16px; box-shadow: 0 10px 30px rgba(0,0,0,.25)}
    .grid{display:grid; gap:16px}
    .grid.cols-3{grid-template-columns: repeat(3, minmax(0,1fr))}
    .stat{padding:16px; border-radius:14px; background:radial-gradient(1200px 600px at -10% -10%, rgba(34,211,238,.08), transparent), #0b132a; border:1px solid var(--border)}
    .stat .label{color:var(--muted); font-size:.85rem}
    .stat .value{font-size:1.8rem; font-weight:800; margin-top:6px}

    table{width:100%; border-collapse: collapse}
    th,td{padding:12px 12px; border-bottom:1px solid var(--border); text-align:left}
    th{color:#c9cfe1; font-weight:700}

    .toolbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; gap:10px}
    .input, select, textarea{width:100%; padding:10px 12px; border-radius:10px; background:#0a1230; border:1px solid var(--border); color:#e6e9f2}
    form .row{display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px}
    form label{display:block; font-size:.9rem; color:#c9cfe1; margin-bottom:6px}
    .muted{color:var(--muted)}
    .flash{margin: 12px 0; padding: 10px 12px; border-radius: 10px; background: #0e2b1b; color: #c7f9d4; border: 1px solid #14532d}

    @media (max-width: 1024px){ .layout{grid-template-columns: 1fr} .sidebar{position:static; height:auto; border-right:none} }
  </style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand"><span class="dot"></span> <span>Admin</span></div>
    <div class="search">
      <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 21l-4.35-4.35" stroke="#9aa7c7" stroke-width="2" stroke-linecap="round"/><circle cx="10" cy="10" r="7" stroke="#9aa7c7" stroke-width="2" fill="none"/></svg>
      <input type="search" placeholder="Search..." />
    </div>
    <div class="nav">
      <div class="section">Overview</div>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
      <div class="section">Catalog</div>
      <a href="{{ route('admin.books.index') }}" class="{{ request()->is('admin/books*') ? 'active' : '' }}">Books</a>
      <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">Categories</a>
      <div class="section">Commerce</div>
      <a href="{{ route('admin.enquiries.index') }}" class="{{ request()->is('admin/enquiries*') ? 'active' : '' }}">Enquiries</a>
      <a href="{{ route('admin.rentals.index') }}" class="{{ request()->is('admin/rentals*') ? 'active' : '' }}">Rentals</a>
      <a href="{{ route('admin.sales.index') }}" class="{{ request()->is('admin/sales*') ? 'active' : '' }}">Sales</a>
      <div class="section">Users</div>
      <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">Users</a>
    </div>
  </aside>
  <div>
    <div class="top">
      <div class="muted">{{ ucfirst(explode('.', Route::currentRouteName() ?? 'dashboard')[1] ?? 'Dashboard') }}</div>
      <div class="user-actions">
        <form action="{{ route('admin.logout') }}" method="post">
          @csrf
          <button class="btn">Logout</button>
        </form>
      </div>
    </div>
    <div class="container">
      @if(session('status'))
        <div class="flash">{{ session('status') }}</div>
      @endif
      @yield('content')
    </div>
  </div>
</div>
</body>
</html>