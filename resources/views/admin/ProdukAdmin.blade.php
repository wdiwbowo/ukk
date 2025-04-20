@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Produk</h2>

   <!-- Form Pencarian (tanpa tombol) -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-3" id="search-form">
        <div class="input-group">
            <input type="text" class="form-control" name="search" id="search-input" value="{{ request()->get('search') }}" placeholder="Cari produk...">
        </div>
    </form>

    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
            });
        });
    </script>
    @endif

    <!-- Card Container for the table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Produk</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fa fa-plus"></i> Tambah Produk
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><img src="{{ asset('image/' . $product->gambar) }}" width="150"></td>
                            <td>{{ $product->name_product }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editStockModal{{ $product->id }}">
                                    <i class="fa fa-box"></i> Edit Stok
                                </button>
                                <button class="btn btn-danger btn-sm delete-product" data-id="{{ $product->id }}" data-name="{{ $product->name_product }}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>

                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('modals.AdminProduk.add_product')
@include('modals.AdminProduk.edit_product')
@include('modals.AdminProduk.edit_stock')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-product").forEach(button => {
            button.addEventListener("click", function() {
                let productId = this.getAttribute("data-id");
                let productName = this.getAttribute("data-name");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: `Produk "${productName}" akan dihapus secara permanen!`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${productId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection
