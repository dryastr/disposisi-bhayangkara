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
                            <div class="d-flex justify-content-start mt-3">
                                <a href="{{ route('lembar-disposisi-user.index') }}"
                                    class="btn btn-secondary me-1 mb-1">Kembali</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($disposisi->source)
                                <div class="form-group">
                                    <label>File Surat:</label>
                                    <iframe id="surat-iframe" src="{{ Storage::url($disposisi->source) }}" width="100%"
                                        height="600px"></iframe>
                                    <button id="fullscreen-button" class="btn btn-primary mt-2">Tampilkan
                                        Fullscreen</button>
                                </div>
                            @else
                                <p>File surat tidak tersedia.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('fullscreen-button').addEventListener('click', function() {
            var iframe = document.getElementById('surat-iframe');
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.mozRequestFullScreen) {
                iframe.mozRequestFullScreen();
            } else if (iframe.webkitRequestFullscreen) {
                iframe.webkitRequestFullscreen();
            } else if (iframe.msRequestFullscreen) {
                iframe.msRequestFullscreen();
            }
        });
    </script>
@endpush
