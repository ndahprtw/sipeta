<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard Nav -->
    <li class="nav-item">
      <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard*') ? '' : 'collapsed' }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    @if ( Auth::user()->role == 'Admin' )
      <!-- Nav -->
      <li class="nav-item">
        <a href="{{ url('/data-staff') }}" class="nav-link {{ Request::is('data-staff*') ? '' : 'collapsed' }}">
          <i class="bi bi-people-fill"></i>
          <span>Data Karyawan</span>
        </a>
      </li><!-- End Nav -->

      <!-- Nav -->
      <li class="nav-item">
        <a href="{{ url('/kategori-lahan') }} " class="nav-link {{ Request::is('kategori-lahan*') ? '' : 'collapsed' }}">
          <i class="bi bi-palette"></i>
          <span>Kategori Lahan</span>
        </a>
      </li><!-- End Nav -->

    @endif
     
    <!-- Nav -->
    <li class="nav-item">
      <a href="{{ url('/data-pemilik') }}" class="nav-link {{ Request::is('data-pemilik*') ? '' : 'collapsed' }}">
        <i class="bi bi-people"></i>
        <span>Data Pemilik</span>
      </a>
    </li><!-- End Nav -->

    <!-- Nav -->
    <li class="nav-item">
      <a href="{{ url('/data-lahan') }} " class="nav-link {{ Request::is('data-lahan*') ? '' : 'collapsed' }}">
        <i class="bi bi-database"></i>
        <span>Data Lahan</span>
      </a>
    </li><!-- End Nav -->

    <!-- Nav -->
    <li class="nav-item">
      <a href="{{ url('/maps') }}" class="nav-link {{ Request::is('maps*') ? '' : 'collapsed' }}">
        <i class="bi bi-geo-alt-fill"></i>
        <span>Maps</span>
      </a>
    </li><!-- End Nav -->

    <!-- Logout Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="/logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
      </a>
    </li><!-- End Logout Nav -->

  </ul>

</aside><!-- End Sidebar -->
