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
        <div class="card-header">
            <h5 class="mb-0">Daftar Produk</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><img src="{{ asset('image/' . $product->gambar) }}" width="150"></td>
                            <td>{{ $product->name_product }}</td>
                            <td>{{ $product->kategori }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
