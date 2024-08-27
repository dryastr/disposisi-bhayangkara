@extends('layouts.main')

@section('title', 'Ubah Pengguna')

@push('header-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ubah Pengguna</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('add-users.update', $user->id) }}" method="POST" class="form form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Nama Pengguna</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="name" class="form-control" name="name"
                                        value="{{ $user->name }}" maxlength="100" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="email" id="email" class="form-control" name="email"
                                        value="{{ $user->email }}" maxlength="13" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="no_telp">No. Telepon</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="no_telp" class="form-control" name="no_telp"
                                        value="{{ $user->no_telp }}" maxlength="13">
                                    <span id="no_telp-help" class="form-text text-muted">*Maksimal 13 digit.</span>
                                </div>

                                <div class="col-md-4">
                                    <label for="role_id">Role</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select id="role_id" class="form-control" name="role_id" required>
                                        <option value="" disabled>Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <div class="input-group">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Password" minlength="8">
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                    <span id="password-help" class="form-text text-muted">*Password harus minimal 8
                                        karakter.</span>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Perubahan</button>
                                    <a href="{{ route('add-users.index') }}"
                                        class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('password');
            var passwordHelp = document.getElementById('password-help');

            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length < 8) {
                    passwordHelp.textContent = 'Password harus minimal 8 karakter.';
                    passwordHelp.classList.add('text-danger');
                } else {
                    passwordHelp.textContent = 'Password valid.';
                    passwordHelp.classList.remove('text-danger');
                    passwordHelp.classList.add('text-success');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var noTelpInput = document.getElementById('no_telp');

            noTelpInput.addEventListener('input', function() {
                noTelpInput.value = noTelpInput.value.replace(/[^0-9]/g, '');

                if (noTelpInput.value.length > 13) {
                    noTelpInput.value = noTelpInput.value.slice(0, 13);
                }
            });
        });
    </script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const passwordIcon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
