@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar Pembelian</h2>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreatePembelian">
    Tambah Penjualan
</button>

            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pembelian</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <tbody>
                            <div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembelian as $index => $transaction)
            <tr>
                <td>{{ ($pembelian->currentPage() - 1) * $pembelian->perPage() + $index + 1 }}</td>
                <td>{{ $transaction->metode_pembayaran }}</td>
                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                <td>{{ $transaction->user->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada pembelian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
    {{ $pembelian->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>


                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.PembelianPetugas.add_pembelian')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const totalHargaElem = document.getElementById('totalHarga');

        checkboxes.forEach(checkbox => {
            const cardBody = checkbox.closest('.card-body');
            const jumlahInput = cardBody.querySelector('.jumlah-input');
            const plusBtn = cardBody.querySelector('.btn-plus');
            const minusBtn = cardBody.querySelector('.btn-minus');
            const stock = parseInt(checkbox.getAttribute('data-stock'));
            
            
            checkbox.addEventListener('change', function () {
                const enabled = this.checked;
                jumlahInput.disabled = !enabled;
                plusBtn.disabled = !enabled;
                minusBtn.disabled = !enabled;
                updateTotal();
            });

            plusBtn.addEventListener('click', function () {
                let val = parseInt(jumlahInput.value) || 1;
                if (val < stock) {
                    jumlahInput.value = val + 1;
                    updateTotal();
                } else {
                    alert(`Stok tidak cukup! Maksimal jumlah produk adalah ${stock}`);
                }
            });

            minusBtn.addEventListener('click', function () {
                let val = parseInt(jumlahInput.value) || 1;
                if (val > 1) {
                    jumlahInput.value = val - 1;
                    updateTotal();
                }
            });

            jumlahInput.addEventListener('input', function () {
                let val = parseInt(jumlahInput.value) || 0;
                if (val > stock) {
                    alert(`Jumlah melebihi stok yang tersedia! Stok maksimal adalah ${stock}`);
                    jumlahInput.value = stock;
                }
                updateTotal();
            });
        });

        function updateTotal() {
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const cardBody = checkbox.closest('.card-body');
                    const harga = parseInt(checkbox.getAttribute('data-harga'));
                    const jumlah = parseInt(cardBody.querySelector('.jumlah-input').value) || 0;
                    total += harga * jumlah;
                }
            });
            totalHargaElem.textContent = total.toLocaleString('id-ID');
        }

        const modal = document.getElementById('modalCreatePembelian');

        // Saat modal dibuka
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const transactionId = button.getAttribute('data-transaction-id');
            document.getElementById('transaction_id').value = transactionId;
        });

        // Saat modal ditutup, reset semua input
        modal.addEventListener('hidden.bs.modal', function () {
            checkboxes.forEach((checkbox, index) => {
                const cardBody = checkbox.closest('.card-body');
                const jumlahInput = cardBody.querySelector('.jumlah-input');
                const plusBtn = cardBody.querySelector('.btn-plus');
                const minusBtn = cardBody.querySelector('.btn-minus');

                checkbox.checked = false;
                jumlahInput.value = 1;
                jumlahInput.disabled = true;
                plusBtn.disabled = true;
                minusBtn.disabled = true;
            });

            document.getElementById('totalHarga').textContent = '0';
            document.getElementById('transaction_id').value = '';
        });
        document.getElementById('btnSelanjutnya').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const selectedItems = [];

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const cardBody = checkbox.closest('.card-body');
            const productName = checkbox.getAttribute('data-nama');
            const jumlah = parseInt(cardBody.querySelector('.jumlah-input').value) || 1;
            const harga = parseInt(checkbox.getAttribute('data-harga')) || 0;

            selectedItems.push({
                name_product: productName,
                jumlah: jumlah,
                harga: harga
            });
        }
    });

    if (selectedItems.length === 0) {
        alert('Pilih setidaknya satu produk.');
        return;
    }

    // Simpan data ke sessionStorage
    sessionStorage.setItem('selectedItems', JSON.stringify(selectedItems));
    
    // Redirect ke halaman pembayaran
    window.location.href = "{{ route('pembayaran.keranjang') }}";
});

    });
</script>
@endsection
