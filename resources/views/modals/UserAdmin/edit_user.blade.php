<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          
          <div class="mb-3">
            <label for="name{{ $user->id }}" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
          </div>

          <div class="mb-3">
            <label for="email{{ $user->id }}" class="form-label">Email</label>
            <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
          </div>

          <div class="mb-3">
            <label for="role{{ $user->id }}" class="form-label">Role</label>
            <select class="form-select" id="role{{ $user->id }}" name="role" required>
              <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="password{{ $user->id }}" class="form-label">Password Baru (opsional)</label>
            <input type="password" class="form-control" id="password{{ $user->id }}" name="password">
          </div>

          <div class="mb-3">
            <label for="password_confirmation{{ $user->id }}" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation{{ $user->id }}" name="password_confirmation">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>
