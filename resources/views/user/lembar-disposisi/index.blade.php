@extends('layouts.main')

@section('title', 'Manajemen Disposisi')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Disposisi</h4>
                    {{-- <a href="{{ route('disposisi.create') }}" class="btn btn-success mb-2">Tambah Disposisi</a> --}}
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl" style="padding-top: 25px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Perihal</th>
                                    <th>Pengirim</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($disposisi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->perihal_surat }}</td>
                                        <td>{{ $item->pengirim }}</td>
                                        <td>{{ $item->tanggal_surat_dibuat }}</td>
                                        <td>{{ $item->tanggal_surat_diterima }}</td>
                                        <td class="text-nowrap">
                                            <div class="dropdown dropup">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton-{{ $item->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('lembar-disposisi-user.show', $item->id) }}">Lihat</a>
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
    @endsection
