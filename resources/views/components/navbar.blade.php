<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="margin-left: 250px; padding-top: 15px; padding-bottom: 15px;">

    <div class="container-fluid">
        <!-- Input Search -->
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Cari di sidebar..." aria-label="Search" id="sidebarSearch">
        </form>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown dengan Ikon Lampu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-lightbulb" style="color: yellow;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Form Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<script>
    // Fungsi untuk mencari item di sidebar
    document.getElementById('sidebarSearch').addEventListener('keyup', function () {
        let searchValue = this.value.toLowerCase();
        let sidebarItems = document.querySelectorAll('.nav-pills .nav-link');

        sidebarItems.forEach(function (item) {
            if (item.textContent.toLowerCase().includes(searchValue)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>

<style>
    body {
        padding-top: 80px; /* Sesuaikan dengan tinggi navbar kamu */
    }
</style>
