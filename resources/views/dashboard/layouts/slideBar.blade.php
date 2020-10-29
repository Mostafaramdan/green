<aside class="main-sidebar open">
      <div class="sidebar-heading d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">مرحبا {{Auth::guard('dashboard')->user()->name}}  </a>
        <i class="fas fa-bars fa-lg icon toggle-sidebar-icon d-none d-xl-block"></i>
        <i class="fas fa-times fa-lg icon toggle-sidebar-icon d-block d-xl-none"></i>
      </div>
      <ul class="nav d-block sidebar-links-container">
        <li class="nav-item  statistics">
          <a class="nav-link {{ Request::is('*statistics*') ? 'active ' : '' }}" href="{{route('dashboard.statistics.index')}}"><i class="fas fa-chart-line mr-2"></i> <span>التقارير</span></a>
        </li>
        <li class="nav-item  users">
          <a class="nav-link {{ Request::is('*users*') ? 'active ' : '' }}" href="{{route('dashboard.users.index')}}"><i class="fas fa-users mr-2"></i> <span>المستخدمين</span></a>
        </li>
        <li class="nav-item notifications">
          <a class="nav-link {{ Request::is('*notifications*') ? 'active ' : '' }}" href="{{route('dashboard.notifications.index')}}"><i class="far fa-bell  mr-2"></i><span>الإشعارات</span></a>
        </li>
        <li class="nav-item contact_us">
          <a class="nav-link {{ Request::is('*contact_us*') ? 'active ' : '' }}" href="{{route('dashboard.contact_us.index')}}"><i class="fas fa-envelope-open-text mr-2" ></i><span>الشكاوي والإقتراحات</span></a>
        </li>
        <li class="nav-item categories">
          <a class="nav-link {{ Request::is('*categories*') ? 'active ' : '' }}" href="{{route('dashboard.categories.index')}}"><i class="fas fa-list mr-2"></i><span>الأقسام</span></a>
        </li>
        <li class="nav-item products">
          <a class="nav-link {{ Request::is('*products*') ? 'active ' : '' }}" href="{{route('dashboard.products.index')}}"><i class="fas fa-taxi mr-2"></i><span>المنتجات</span></a>
        </li>
        <li class="nav-item orders">
          <a class="nav-link {{ Request::is('*orders*') ? 'active ' : '' }}" href="{{route('dashboard.orders.index')}}"><i class="fas fa-money-bill mr-2"></i><span>الطلبات</span></a>
        </li>
        <li class="nav-item regions">
          <a class="nav-link {{ Request::is('*regions*') ? 'active ' : '' }}" href="{{route('dashboard.regions.index')}}"><i class="fas fa-globe mr-2"></i><span>الدول /المدن</span></a>
        </li>
        <li class="nav-item sliders">
          <a class="nav-link {{ Request::is('*sliders*') ? 'active ' : '' }}" href="{{route('dashboard.sliders.index')}}"><i class="fab fa-adversal fa-1x mr-2"></i><span>الأعلانات</span></a>
        </li>
        <li class="nav-item delivery_time">
          <a class="nav-link {{ Request::is('*delivery_time*') ? 'active ' : '' }}" href="{{route('dashboard.delivery_time.index')}}"><i class="fas fa-clock fa-1x mr-2"></i></i><span>أوقات التوصيل</span></a>
        </li>
        <li class="nav-item vouchers">
          <a class="nav-link {{ Request::is('*vouchers*') ? 'active ' : '' }}" href="{{route('dashboard.vouchers.index')}}"><i class="fas fa-percent fa-1x mr-2"></i></i><span>اكواد الخصم</span></a>
        </li>
        <li class="nav-item admins">
          <a class="nav-link {{ Request::is('*admins*') ? 'active ' : '' }}" href="{{route('dashboard.admins.index')}}"><i class="fas fa-user fa-1x mr-2"></i><span>المسؤولين</span></a>
        </li>
        <!-- <li class="nav-item orders">
          <a class="nav-link {{ Request::is('*orders*') ? 'active ' : '' }}" href="{{route('dashboard.orders.index')}}"><i class="fas fa-luggage-cart mr-2"></i><span>الطلبات</span></a>
        </li> -->
        <li class="nav-item app_settings">
          <a class="nav-link {{ Request::is('*app_settings*') ? 'active ' : '' }}" href="{{route('dashboard.app_settings.index')}}"><i class="fas fa-cogs  mr-2"></i><span>إعدادات التطبيق </span></a>
        </li>
        </li>
      </ul>
</aside>