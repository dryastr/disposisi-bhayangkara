@extends('layouts.main')

@section('title', 'Manajemen Disposisi')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Disposisi</h4>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="null-tab" data-bs-toggle="tab" href="#null" role="tab"
                                aria-controls="null" aria-selected="true">Belum Dikirim</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="is-user-tab" data-bs-toggle="tab" href="#is-user" role="tab"
                                aria-controls="is-user" aria-selected="false">Sudah Dikirim</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="null" role="tabpanel" aria-labelledby="null-tab">
                            <div class="table-responsive mt-3">
                                <table class="table table-xl">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Surat</th>
                                            <th>Perihal</th>
                                            <th>Pengirim</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Tanggal Diterima</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($disposisiNullIsUser as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->no_surat }}</td>
                                                <td>{{ $item->perihal_surat }}</td>
                                                <td>{{ $item->pengirim }}</td>
                                                <td>{{ $item->tanggal_surat_dibuat }}</td>
                                                <td>{{ $item->tanggal_surat_diterima }}</td>
                                                <td>
                                                    @if ($item->status == 'diterima')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($item->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $item->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('lembar-disposisi-karumkit.show', $item->id) }}">Lihat</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="is-user" role="tabpanel" aria-labelledby="is-user-tab">
                            <div class="table-responsive mt-3">
                                <table class="table table-xl">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Surat</th>
                                            <th>Perihal</th>
                                            <th>Pengirim</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Tanggal Diterima</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($disposisiIsUser as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->no_surat }}</td>
                                                <td>{{ $item->perihal_surat }}</td>
                                                <td>{{ $item->pengirim }}</td>
                                                <td>{{ $item->tanggal_surat_dibuat }}</td>
                                                <td>{{ $item->tanggal_surat_diterima }}</td>
                                                <td>
                                                    @if ($item->status == 'diterima')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($item->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $item->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('lembar-disposisi-karumkit.show', $item->id) }}">Lihat</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
