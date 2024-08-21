@extends('layouts.main')

@section('title', 'Tambah Disposisi')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Disposisi</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('disposisi.store') }}" method="POST" enctype="multipart/form-data"
                        class="form form-horizontal">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="no_surat">No Surat</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="no_surat" class="form-control" name="no_surat"
                                        placeholder="No Surat" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="perihal_surat">Perihal Surat</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <textarea id="perihal_surat" class="form-control" name="perihal_surat" placeholder="Perihal Surat" required></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label for="pengirim">Pengirim</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="pengirim" class="form-control" name="pengirim"
                                        placeholder="Pengirim" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal_surat_dibuat">Tanggal Surat Dibuat</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggal_surat_dibuat" class="form-control"
                                        name="tanggal_surat_dibuat" placeholder="Tanggal Surat Dibuat" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal_surat_diterima">Tanggal Surat Diterima</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggal_surat_diterima" class="form-control"
                                        name="tanggal_surat_diterima" placeholder="Tanggal Surat Diterima" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="file">File Surat</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="file" id="file" class="form-control" name="file" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="user_id">Pilih Penerima</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select id="user_id" class="form-control" name="user_id" required>
                                        <option value="">-- Pilih Penerima --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="fs-sm">*Data akan dikirimkan ke role 'Spri'</span>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <a href="{{ route('disposisi.index') }}" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
