<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" 
     style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000;">
    <h4 class="text-dark text-center fw-bold">FlexyLite</h4>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        <!-- Admin Sidebar Options -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('admin/dashboard') ? 'active' : 'text-dark' }}">
                <i class="bi bi-grid-fill me-2"></i> Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('products.index') }}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('admin/products*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-shop me-2"></i> Produk
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('admin.pembelian.index')}}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('admin/pembelian') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-cart-fill me-2"></i> Pembelian
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('users.index') }}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('admin/user') ? 'active' : 'text-dark' }}">
                <i class="bi bi-person-fill me-2"></i> User
            </a>
        </li>
        @endif

        <!-- Petugas Sidebar Options -->
        @if(Auth::user()->role == 'petugas')
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('petugas/dashboard') ? 'active' : 'text-dark' }}">
                <i class="bi bi-grid-fill me-2"></i> Dashboard 
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('produk.petugas') }}" 
               class="nav-link fw-semibold fs-5 {{ Request::is('petugas/produk') ? 'active' : 'text-dark' }}">
                <i class="bi bi-shop me-2"></i> Produk
            </a>

        </li>
        <li class="mb-2">
    <a href="{{ route('pembelian.index') }}" 
       class="nav-link fw-semibold fs-5 {{ Request::is('petugas/pembelian*') ? 'active' : 'text-dark' }}">
        <i class="bi bi-cart-fill me-2"></i> Pembelian 
    </a>
</li>


        @endif

    </ul>
</div>
