@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'success',
                        text: '{{ session("success") }}'
                    })
                });
            </script>
        @endif

        <!-- Card untuk Dashboard Petugas -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Dashboard Petugas</h5>
            </div>
            <div class="card-body">
                <!-- Deskripsi Dashboard -->
                <p class="text-center mb-4">Selamat datang di Dashboard Petugas. <br> Anda dapat melihat informasi terkait kegiatan dan tugas yang harus diselesaikan di sini.</p>

                <!-- Informasi terkait -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-info">
                            <div class="card-body">
                                <h5 class="card-title">Tugas yang Belum Selesai</h5>
                                <p class="card-text">Jumlah tugas yang belum selesai: <strong>5</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">Tugas yang Selesai</h5>
                                <p class="card-text">Jumlah tugas yang telah selesai: <strong>12</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h5 class="card-title">Tugas Terbaru</h5>
                                <p class="card-text">Tugas terbaru yang diterima: <strong>Periksa Inventaris</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-secondary">
                            <div class="card-body">
                                <h5 class="card-title">Kegiatan Hari Ini</h5>
                                <p class="card-text">Kegiatan yang dijadwalkan untuk hari ini: <strong>3</strong> kegiatan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
