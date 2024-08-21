@extends('layouts.main')

@section('title', 'Manajemen Notifikasi')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Notifikasi</h4>
                    <span class="badge bg-primary">
                        {{ $unreadCount }} Notifikasi Belum Dibaca
                    </span>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl" style="padding-top: 25px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pesan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($announcements as $announcement)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <!-- Tampilkan lingkaran kecil merah jika belum dibaca -->
                                            @if (!$announcement->is_read)
                                                <span style="color:red; font-size:10px; margin-right:5px;">●</span>
                                            @endif
                                            <!-- Link ke detail disposisi jika disposisi_id tersedia -->
                                            @if ($announcement->disposisi_id)
                                                <a href="{{ route('disposisi.show', $announcement->disposisi_id) }}">
                                                    {{ $announcement->title }}
                                                </a>
                                            @else
                                                {{ $announcement->title }}
                                            @endif
                                        </td>
                                        <td>{{ $announcement->message }}</td>
                                        <td>
                                            @if ($announcement->is_read)
                                                <span class="badge bg-success">Dibaca</span>
                                            @else
                                                <span class="badge bg-warning">Belum Dibaca</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($announcement->is_read)
                                                <span class="badge bg-success">Notif telah ditandai sebagai dibaca</span>
                                            @else
                                                <form action="{{ route('notifications.markAsRead', $announcement->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-sm btn-primary">Tandai sebagai
                                                        Dibaca</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada notifikasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
