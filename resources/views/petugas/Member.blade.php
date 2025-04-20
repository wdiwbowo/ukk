@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Menjadi Member</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pesanan Anda</h5>
                    <div class="produk-terpilih">
                        @foreach($selectedItems as $item)
                            <p><strong>Nama Produk:</strong> {{ $item['name_product'] }}<br>
                            <strong>Jumlah:</strong> {{ $item['jumlah'] }}<br>
                            <strong>Subtotal:</strong> Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</p>
                            <hr>
                        @endforeach
                    </div>
                    <h5>Total: <strong id="total_display">Rp 0</strong></h5>
                    <h5>Poin yang Diperoleh: <strong id="points_display">0</strong></h5>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <form id="registerForm" method="POST" action="{{ route('member.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Jumlah Pembayaran (Rp)</label>
                    <input type="text" name="amount" id="amount" class="form-control" required>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif

                <button type="button" id="daftarDanBayar" class="btn btn-primary w-100">Daftar dan Bayar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectedItems = JSON.parse(sessionStorage.getItem('selectedItems')) || [];
    const container = document.querySelector('.produk-terpilih');
    const totalDisplay = document.getElementById('total_display');
    const pointsDisplay = document.getElementById('points_display');
    const total = selectedItems.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);

    selectedItems.forEach(item => {
        const html = `
            <p><strong>Nama Produk:</strong> ${item.name_product}<br>
            <strong>Jumlah:</strong> ${item.jumlah}<br>
            <strong>Subtotal:</strong> Rp ${item.harga * item.jumlah}</p>
            <hr>`;
        container.innerHTML += html;
    });

    totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    pointsDisplay.textContent = (total * 0.01).toLocaleString('id-ID');

    document.getElementById('daftarDanBayar').addEventListener('click', function () {
        const form = document.getElementById('registerForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                handlePembayaran();
            } else {
                alert('Gagal mendaftar member.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mendaftar!');
        });
    });

    function handlePembayaran() {
    const amount = document.getElementById('amount').value.replace(/\D/g, '');
    fetch('/pembayaran-endpoint', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount: parseInt(amount) })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Pembayaran berhasil!');
            // redirect atau lakukan aksi lain jika perlu
        } else {
            alert('Pembayaran gagal!');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Terjadi kesalahan saat pembayaran!');
    });
}
});
</script>
@endsection