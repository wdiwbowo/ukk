@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pembayaran</h2>

    <div class="row">
        <!-- Bagian Produk -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Produk yang dipilih</h5>
                    <div class="produk-terpilih"></div>
                    <h5>Total: <strong id="total_display">Rp. 0</strong></h5>
                </div>
            </div>
        </div>

        <!-- Form Pembayaran -->
        <div class="col-md-6 mb-4">
            <form method="POST" action="{{ route('petugas.transaksi.store') }}">
                @csrf

                <!-- Hidden input untuk menyimpan data transaksi -->
                <input type="hidden" name="transaction_id" value="{{ session('transactionId') }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="items_json" id="items_json" value="{{$items}}">

                <!-- Pilihan Member atau Non-member -->
                <div class="mb-3">
                    <label for="metode_pembayaran" class="form-label d-inline">Member Status</label>
                    <small class="text-danger d-inline ms-2">Dapat juga membuat member</small> <!-- Teks di sebelah label -->
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select mt-2">
                        <option value="non-member">Bukan Member</option>
                        <option value="member">Member</option>
                    </select>
                </div>

                <!-- Input Nomor HP (muncul jika member dipilih) -->
                <div class="mb-3 d-none" id="phone_number_field">
                    <label for="phone_number" class="form-label">No Telepon (Daftar/Gunakan Member)</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control">
                    <!-- Tombol cek member -->
                    <button type="button" id="check_member_btn" class="btn btn-info mt-2">Cek Member</button>
                </div>

                <!-- Identitas Member -->
                <div class="mb-3 d-none" id="nama_member_field">
                    <label class="form-label">Nama Member</label>
                    <input type="text" id="nama_member" class="form-control" readonly>
                </div>

                <!-- Pesan jika member tidak ditemukan -->
                <div class="alert alert-warning d-none mt-2" id="member_not_found_msg">
                    Nomor ini belum terdaftar sebagai member.
                    <a href="{{ route('member.create') }}" class="btn btn-sm btn-primary ms-2">Daftarkan Sekarang</a>
                </div>

                <!-- Input Total Bayar (diformat + hidden untuk data mentah) -->
                <div class="mb-3">
                    <label for="jumlah_bayar_formatted" class="form-label">Total Bayar</label>
                    <input type="text" id="jumlah_bayar_formatted" class="form-control" required>
                    <input type="hidden" name="jumlah_bayar" id="jumlah_bayar">
                </div>

                <!-- Tombol submit -->
                <button type="submit" class="btn btn-primary w-100">Pesan</button>
            </form>
        </div>
    </div>
</div>

<!-- Script JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectedItems = JSON.parse(sessionStorage.getItem('selectedItems')) || [];
    const container = document.querySelector('.produk-terpilih');
    const totalDisplay = document.getElementById('total_display');
    const metodePembayaran = document.getElementById('metode_pembayaran');
    const phoneNumberField = document.getElementById('phone_number_field');
    const formattedInput = document.getElementById('jumlah_bayar_formatted');
    const hiddenInput = document.getElementById('jumlah_bayar');
    const phoneInput = document.getElementById('phone_number');
    const checkMemberBtn = document.getElementById('check_member_btn');
    const memberNotFoundMsg = document.getElementById('member_not_found_msg');
    const namaMemberField = document.getElementById('nama_member_field');
    const namaMemberDisplay = document.getElementById('nama_member');
    const submitBtn = document.querySelector('button[type="submit"]');
    const insufficientFundsMsg = document.createElement('div');

    let total = 0;
    let isMemberValid = false; // ✅ Tambahkan flag validasi member

    document.getElementById('items_json').value = JSON.stringify(selectedItems);

    // Tampilkan produk dan hitung total
    selectedItems.forEach(item => {
        const productName = item.name_product || 'Tidak diketahui';
        const jumlah = item.jumlah || 1;
        const subtotal = item.harga ? item.harga * jumlah : 0;
        total += subtotal;

        const itemHtml = ` 
            <p><strong>Nama Produk:</strong> ${productName}<br>
            <strong>Jumlah:</strong> ${jumlah}<br>
            <strong>Subtotal:</strong> Rp ${subtotal.toLocaleString('id-ID')}</p>
            <hr>
        `;
        container.innerHTML += itemHtml;
    });

    totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    formattedInput.value = '';
    hiddenInput.value = '';

    // Toggle field berdasarkan pilihan
    metodePembayaran.addEventListener('change', function () {
        if (this.value === 'member') {
            phoneNumberField.classList.remove('d-none');
        } else {
            phoneNumberField.classList.add('d-none');
            namaMemberField.classList.add('d-none');
            memberNotFoundMsg.classList.add('d-none');
            isMemberValid = false; // ✅ Reset validasi
        }
    });

    // Cek Member
    checkMemberBtn.addEventListener('click', function () {
        const phone = phoneInput.value.trim();
        if (!phone) {
            alert("Nomor telepon tidak boleh kosong.");
            return;
        }

        fetch("{{ route('petugas.checkMember') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ phone_number: phone })
        })
        .then(res => res.json())
        .then(data => {
            if (data.exists) {
                isMemberValid = true; // ✅ Validasi berhasil
                namaMemberField.classList.remove('d-none');
                namaMemberDisplay.value = data.member.name;
                memberNotFoundMsg.classList.add('d-none');

                formattedInput.value = `Rp ${total.toLocaleString('id-ID')}`;
                hiddenInput.value = total;
            } else {
                isMemberValid = false; // ❌ Tidak ditemukan
                namaMemberField.classList.add('d-none');
                memberNotFoundMsg.classList.remove('d-none');
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan saat mengecek member.");
        });
    });

    // Format input rupiah
    formattedInput.addEventListener('input', function (e) {
        let rawValue = e.target.value.replace(/\D/g, '');
        if (rawValue) {
            e.target.value = `Rp ${parseInt(rawValue).toLocaleString('id-ID')}`;
            hiddenInput.value = rawValue;
            validateAmount(); // Validasi setiap kali input diubah
        } else {
            e.target.value = '';
            hiddenInput.value = '';
            validateAmount();
        }
    });

    // Validasi jumlah uang dan disable submit jika kurang
    function validateAmount() {
        const inputAmount = parseInt(hiddenInput.value);
        if (inputAmount < total) {
            if (!insufficientFundsMsg.parentElement) {
                insufficientFundsMsg.classList.add('alert', 'alert-danger', 'mt-2');
                insufficientFundsMsg.textContent = "Uang yang Anda masukkan tidak cukup.";
                document.querySelector('form').appendChild(insufficientFundsMsg);
            }
            submitBtn.disabled = true;
        } else {
            if (insufficientFundsMsg.parentElement) {
                insufficientFundsMsg.remove();
            }
            submitBtn.disabled = false;
        }
    }

    // Validasi sebelum submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        if (metodePembayaran.value === 'member') {
            const phone = phoneInput.value.trim();

            if (!phone) {
                e.preventDefault();
                alert("Silakan isi nomor HP untuk member.");
                return;
            }

            if (!isMemberValid) {
                e.preventDefault();
                alert("Silakan klik 'Cek Member' dan pastikan nomor sudah tervalidasi.");
                return;
            }
        }

        // Debug log
        console.log("Form sedang dikirim...");
        console.log("transaction_id:", document.querySelector('input[name="transaction_id"]').value);
        console.log("user_id:", document.querySelector('input[name="user_id"]').value);
        console.log("jumlah_bayar:", hiddenInput.value);
        console.log("metode_pembayaran:", metodePembayaran.value);
        console.log("nomor_hp:", phoneInput.value);
    });
});
</script>

@endsection