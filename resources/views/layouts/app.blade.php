<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name', 'USAVRCN') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="{{ url('/') }}">USAVRCN Member Database</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('members.index') }}">Members</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('groups.index') }}">Groups</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('posts.public') }}">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
          </li> --}}
        </ul>
        
        <ul class="navbar-nav">
          @auth
            {{-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu">
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('entities.edit', Auth::user()->entity) }}">Profile</a>
                </li>
              </ul>
            </li> --}}

            {{-- admin pages --}}
            @can('admin')
              <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                  Admin Pages
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="{{ route('tags.index') }}">Tags</a>
                  </li>
                </ul>
              </li>
            @endcan

            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link px-0">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <!-- Tab Navigation -->
  @php
    $isGroupsPage = request()->routeIs('groups.*');
  @endphp
  <div class="container mt-3 d-flex justify-content-between">
      <div class="btn-group btn-group p-1 rounded-pill" style="background-color: rgba(0,0,0,0.05)" role="group">
          <button type="button"
                  class="btn fw-semibold rounded-pill border-0 {{ !$isGroupsPage ? 'btn-light' : '' }}"
                  @if(!$isGroupsPage) disabled @endif
                  @if(!!$isGroupsPage) onclick="window.location.href='{{ route('members.index') }}'" @endif
          >Member Database</button>
          <button type="button"
                  class="btn fw-semibold rounded-pill border-0 {{ $isGroupsPage ? 'btn-light' : '' }}"
                  @if($isGroupsPage) disabled @endif
                  @if(!$isGroupsPage) onclick="window.location.href='{{ route('groups.index') }}'" @endif
          >Groups
            {{-- TODO: What does this number mean? --}}
            <span class="badge bg-primary ms-1 p-1">15</span>
          </button>
      </div>

      @auth
      <div class="p-1 rounded-pill bg-light border" style="background-color: rgba(0,0,0,0.05)">
        <button type="button"
                class="btn fw-semibold border-0"
                onclick="window.location.href='{{ route('members.show', Auth::user()->entity) }}'">
                 <i class="bi bi-person text-muted"></i>
                My Profile</button>
      </div>
      @endauth
  </div>

  <main class="py-4">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
