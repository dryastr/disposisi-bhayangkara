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
                                <a href="{{ route('lembar-disposisi.index') }}"
                                    class="btn btn-secondary me-1 mb-1">Kembali</a>
                                <button type="button" class="btn btn-success me-1 mb-1" data-bs-toggle="modal"
                                    data-bs-target="#acceptModal">Diterima</button>
                                <button type="button" class="btn btn-danger me-1 mb-1" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">Ditolak</button>
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

    <!-- Accept Modal -->
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acceptModalLabel">Konfirmasi Penerimaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menerima disposisi ini?</p>
                    <p>Pilih Karumkit untuk mengirimkan email:</p>
                    <form action="{{ route('lembar-disposisi.terima', $disposisi->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="karumkit_id" class="form-label">Karumkit:</label>
                            <select id="karumkit_id" name="karumkit_id" class="form-select" required>
                                <option value="" disabled selected>Pilih Karumkit</option>
                                @foreach ($karumkit as $karumkitUser)
                                    <option value="{{ $karumkitUser->id }}">{{ $karumkitUser->name }}
                                        ({{ $karumkitUser->email }})</option>
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
    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reject-form" action="{{ route('lembar-disposisi.tolak', $disposisi->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Penolakan:</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
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
