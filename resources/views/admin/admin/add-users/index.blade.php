@extends('layouts.main')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <a href="{{ route('add-users.create') }}" class="btn btn-success">Tambah Pengguna</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="userTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab"
                                    aria-controls="admin" aria-selected="true">Admin</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="spri-tab" data-bs-toggle="tab" href="#spri" role="tab"
                                    aria-controls="spri" aria-selected="false">Spri</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="karumkit-tab" data-bs-toggle="tab" href="#karumkit" role="tab"
                                    aria-controls="karumkit" aria-selected="false">Karumkit</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user" role="tab"
                                    aria-controls="user" aria-selected="false">Penerima Disposisi</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="userTabContent">
                            <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                                @include('admin.admin.add-users.partials.user_table', ['users' => $users->where('role.name', 'admin')])
                            </div>
                            <div class="tab-pane fade" id="spri" role="tabpanel" aria-labelledby="spri-tab">
                                @include('admin.admin.add-users.partials.user_table', ['users' => $users->where('role.name', 'spri')])
                            </div>
                            <div class="tab-pane fade" id="karumkit" role="tabpanel" aria-labelledby="karumkit-tab">
                                @include('admin.admin.add-users.partials.user_table', ['users' => $users->where('role.name', 'karumkit')])
                            </div>
                            <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                @include('admin.admin.add-users.partials.user_table', ['users' => $users->where('role.name', 'user')])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
