<!-- Modal Create Pembelian -->
<div class="modal fade" id="modalCreatePembelian" tabindex="-1" aria-labelledby="modalCreatePembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
                            @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Produk dan Jumlah</label>
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset('image/' . $product->gambar) }}" class="card-img-top" alt="{{ $product->name_product }}" style="height: 300px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name_product }}</h5>
                                        <p class="card-text mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                        <p class="card-text text-muted mb-2">Stok: {{ $product->stok }}</p>

                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input product-checkbox"
                                                id="produk{{ $product->id }}"
                                                data-nama="{{ $product->name_product }}"
                                                data-harga="{{ $product->harga }}"
                                                data-stock="{{ $product->stok }}">
                                             <label class="form-check-label" for="produk{{ $product->id }}">Pilih Produk Ini</label>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Jumlah</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-secondary btn-minus" disabled>-</button>
                                                <input type="number" class="form-control jumlah-input" value="1" min="1" max="{{ $product->stok }}" disabled>
                                                <button type="button" class="btn btn-outline-secondary btn-plus" disabled>+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5><strong>Total Harga: Rp <span id="totalHarga">0</span></strong></h5>
                        <!-- Button Selanjutnya -->
                        <button type="button" class="btn btn-primary" id="btnSelanjutnya">Selanjutnya</button>
                    </div>
