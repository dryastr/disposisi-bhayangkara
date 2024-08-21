@extends('layouts.main')

@section('title', 'Detail Disposisi')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail Disposisi</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Penerima Surat:</label>
                                <p>{{ $disposisi->user->name ?? 'Tidak ada penerima' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Nama Surat:</label>
                                <p>{{ $disposisi->file_name_surat }}</p>
                            </div>
                            <div class="form-group">
                                <label>No Surat:</label>
                                <p>{{ $disposisi->no_surat }}</p>
                            </div>
                            <div class="form-group">
                                <label>Perihal Surat:</label>
                                <p>{{ $disposisi->perihal_surat }}</p>
                            </div>
                            <div class="form-group">
                                <label>Pengirim:</label>
                                <p>{{ $disposisi->pengirim }}</p>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Surat Dibuat:</label>
                                <p>{{ $disposisi->tanggal_surat_dibuat }}</p>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Surat Diterima:</label>
                                <p>{{ $disposisi->tanggal_surat_diterima }}</p>
                            </div>
                            <div class="form-group">
                                <label>Status:</label>
                                <p>{{ ucfirst($disposisi->status) }}</p>
                            </div>
                            <div class="form-group">
                                <label>Keterangan:</label>
                                <p>{{ $disposisi->keterangan ?? 'Tidak ada keterangan' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($disposisi->source)
                                <div class="form-group">
                                    <label>File Surat:</label>
                                    <iframe src="{{ Storage::url($disposisi->source) }}" width="100%"
                                        height="600px"></iframe>
                                </div>
                            @else
                                <p>File surat tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('disposisi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
