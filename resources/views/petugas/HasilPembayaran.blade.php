@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">🧾 Detail Pembayaran</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Info Transaksi -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            <hr>

            <!-- Produk -->
            <h5 class="mb-3"><strong>🛒 Produk yang Dibeli</strong></h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->details as $detail)
                        <tr>
                            <td>{{ $detail->product->nama_produk }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            <!-- Total Pembayaran -->
            <div class="mb-3">
                <h5><strong>💰 Total Pembayaran:</strong> Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</h5>
            </div>

            <!-- Status Pembayaran -->
            @if ($transaction->pembayaran)
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1"><strong>Total Bayar:</strong> Rp {{ number_format($transaction->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    <p class="mb-1"><strong>Kembalian:</strong> Rp {{ number_format($transaction->pembayaran->kembalian, 0, ',', '.') }}</p>
                    <p class="mb-0"><strong>Status Pembayaran:</strong> 
                        <span class="badge bg-{{ $transaction->pembayaran->status == 'sukses' ? 'success' : 'danger' }}">
                            {{ ucfirst($transaction->pembayaran->status) }}
                        </span>
                    </p>
                </div>
                <i class="bi bi-check-circle-fill text-success fs-2"></i>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Belum ada pembayaran untuk transaksi ini.
            </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="mt-4">
                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                
            </div>
        </div>
    </div>
</div>
@endsection
