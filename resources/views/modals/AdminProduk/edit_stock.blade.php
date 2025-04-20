@foreach ($products as $product)
<div class="modal fade" id="editStockModal{{ $product->id }}" tabindex="-1" aria-labelledby="editStockModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.updateStock', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Stok Baru</label>
                        <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Tambah Stok</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
