<input type="hidden" class="form-control" name="email">
<input type="hidden" class="form-control" name="password">
<div class="loading-container"  >
  <div class="spinner-border text-primary" role="status">
  </div>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="main-content col p-0">
  <!-- header -->
  <div class="header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <i class="fas fa-bars fa-lg icon toggle-sidebar-icon d-block d-xl-none"></i>
      <div class="ml-auto d-flex">
        <a class="nav-link text-primary" href="#">{{Auth::guard('dashboard')->user()->name}}</a>
        <a class="nav-link" style="transform: rotate(180deg);" href="{{route('dashboard.logout')}}"><i class="fas fa-sign-out-alt fa-lg icon text-primary"></i></a>
      </div>
    </nav>
  </div>