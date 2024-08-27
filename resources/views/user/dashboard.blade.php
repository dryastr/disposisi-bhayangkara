@extends('layouts.main')

@section('title', 'Dashboard Penerima Disposisi')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card-body mb-4">
                <p class="card-text">Hi, Selamat Datang <strong>{{ Auth::user()->name }}</strong>!</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Jam Real-Time WIB</h5>
                </div>
                <div class="card-body">
                    <p id="clock" class="card-text"></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Total Disposisi</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Jumlah disposisi yang diterima saat ini adalah
                        <strong>{{ $disposisiCount }}</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4 d-none">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Grafik Disposisi per Bulan</h5>
                </div>
                <div class="card-body">
                    <canvas id="disposisiChart"></canvas>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // var ctx = document.getElementById('disposisiChart').getContext('2d');
            // var disposisiChart = new Chart(ctx, {
            //     type: 'line',
            //     data: {
            //         labels: @json($months),
            //         datasets: [{
            //                 label: 'Diterima',
            //                 data: @json(array_values($acceptedData)),
            //                 borderColor: 'rgba(75, 192, 192, 1)',
            //                 backgroundColor: 'rgba(75, 192, 192, 0.2)',
            //                 fill: true,
            //                 tension: 0.2
            //             },
            //             {
            //                 label: 'Ditolak',
            //                 data: @json(array_values($rejectedData)),
            //                 borderColor: 'rgba(255, 99, 132, 1)',
            //                 backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //                 fill: true,
            //                 tension: 0.2
            //             },
            //             {
            //                 label: 'Pending',
            //                 data: @json(array_values($pendingData)),
            //                 borderColor: 'rgba(255, 206, 86, 1)',
            //                 backgroundColor: 'rgba(255, 206, 86, 0.2)',
            //                 fill: true,
            //                 tension: 0.2
            //             }
            //         ]
            //     },
            //     options: {
            //         scales: {
            //             x: {
            //                 title: {
            //                     display: true,
            //                     text: 'Bulan'
            //                 }
            //             },
            //             y: {
            //                 title: {
            //                     display: true,
            //                     text: 'Jumlah Disposisi'
            //                 }
            //             }
            //         }
            //     }
            // });

            function updateClock() {
                const now = new Date();
                const localOffset = now.getTimezoneOffset() * 60000;
                const wibOffset = 7 * 60 * 60 * 1000;
                const wibTime = new Date(now.getTime() + localOffset + wibOffset);

                const hours = String(wibTime.getHours()).padStart(2, '0');
                const minutes = String(wibTime.getMinutes()).padStart(2, '0');
                const seconds = String(wibTime.getSeconds()).padStart(2, '0');

                document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
            }

            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>
@endpush
