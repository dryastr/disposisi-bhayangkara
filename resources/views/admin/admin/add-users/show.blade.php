@extends('layouts.main')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Pengguna</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nama:</strong> {{ $user->name }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ $user->email }}
                </div>
                <div class="mb-3">
                    <strong>Telepon:</strong> {{ $user->no_telp }}
                </div>
                <div class="mb-3">
                    <strong>Role:</strong> {{ $user->role->name }}
                </div>
            </div>
        </div>
    </div>
@endsection
