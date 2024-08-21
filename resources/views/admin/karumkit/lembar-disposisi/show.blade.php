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
                                <p>{{ $disposisi->users->pluck('name')->join(', ') ?? 'Tidak ada penerima' }}</p>
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
                            <div class="d-flex justify-content-start mt-3">
                                <a href="{{ route('lembar-disposisi-karumkit.index') }}"
                                    class="btn btn-secondary me-1 mb-1">Kembali</a>
                                <button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal"
                                    data-bs-target="#kirimModal">Kirim ke Penerima Disposisi</button>
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

    <!-- Modal Kirim -->
    <div class="modal fade" id="kirimModal" tabindex="-1" aria-labelledby="kirimModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimModalLabel">Kirim ke Penerima Disposisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lembar-disposisi-karumkit.kirim', $disposisi->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="karumkit_id">Pilih Penerima:</label>
                            <select class="form-control" id="karumkit_id" name="karumkit_id" required>
                                @foreach ($karumkit as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
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
