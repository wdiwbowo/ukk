@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar Pembelian</h2>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pembelian</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total Harga</th>
                                    <th>Status Pembelian</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaction->metode_pembayaran }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->metode_pembayaran }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>
                                        <!-- Tambahkan tombol aksi (misalnya, Detail atau Hapus) -->
                                        <a href="{{ route('admin.pembelian.detail', $transaction->id) }}" 
                                           class="btn btn-primary btn-sm">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($pembelian->isEmpty())
                            <p class="text-muted text-center mt-3">Belum ada pembelian.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
