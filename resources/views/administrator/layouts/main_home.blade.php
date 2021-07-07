<!-- ini bagian header -->
@include('administrator.layouts.header_home')

<!-- ini bagian content  -->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

           
            <h5 class="mx-2">Selamat Datang di E-Laboratorium Teknologi Informasi !</h5>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                        <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('administrator.profil') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profil Akun
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row justify-content-center" style="margin-top:15vh">
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.maintenance.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-cogs fa-3x mt-2"></i>
                                <h5 class="mt-4">Maintenance</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.inventaris.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-book fa-3x mt-2"></i>
                                <h5 class="mt-4">Inventaris</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.peminjamanlab.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-desktop fa-3x mt-2"></i>
                                <h5 class="mt-4">Peminjaman Lab</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.jurnal.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-clipboard fa-3x mt-2"></i>
                                <h5 class="mt-4">Jurnal Personal</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.peminjamanalat.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-plug fa-3x mt-2"></i>
                                <h5 class="mt-4">Peminjaman Alat</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.lab.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-plus-circle fa-3x mt-2"></i>
                                <h5 class="mt-4">Penambahan Laboratorium</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.user.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-user-plus fa-3x mt-2"></i>
                                <h5 class="mt-4">Penambahan User</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 mb-4">
                    <a href="{{ route('administrator.log.index') }}">
                        <div class="card" style="height: 10rem;">
                            <div class="card-body text-center">
                                <i class="fa fa-file fa-3x mt-2"></i>
                                <h5 class="mt-4">Log Activity</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @yield('content')
            <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

    </div>

    <!-- ini bagian footer  -->
    @include('administrator.layouts.footer')