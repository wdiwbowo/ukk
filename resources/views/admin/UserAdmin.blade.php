@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Manajemen Pengguna</h2>

    <!-- Form Pencarian (Naik ke atas, tanpa tombol) -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nama pengguna..." value="{{ request('search') }}">
    </form>

    <!-- Notifikasi -->
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

    <!-- Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengguna</h5>
            <!-- Tombol Tambah User -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa fa-plus"></i> Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert dan Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-user").forEach(button => {
            button.addEventListener("click", function () {
                let userId = this.getAttribute("data-id");
                let userName = this.getAttribute("data-name");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: `Pengguna "${userName}" akan dihapus!`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/users/delete/${userId}`;
                    }
                });
            });
        });
    });
</script>

{{-- Include modal add user --}}
@include('modals.UserAdmin.add_user')
@include('modals.UserAdmin.edit_user', ['user' => $user])

@endsection
