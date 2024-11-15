@extends('template.full')

@section('title', 'Dashboard Admin')

@section('content-bc', 'Dashboard Admin')

@section('js')
    <script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/chart.js/chart.umd.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>


    <script>

        function updateCharts() {
            // Fetch active user count
            $.get("{{ route('dashboard.activeUsersCount') }}", function(data) {
                $('#activeUsersCount').text(data.count);
            });

            // Fetch exam participants chart data for the last month
            $.get("{{ route('dashboard.participantsByDate') }}", function(data) {
                const ctx1 = document.getElementById('participantsChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Jumlah Peserta Ujian',
                            data: data.counts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            }
                        }
                    }
                });
            });

            // Fetch gender distribution chart data
            $.get("{{ route('dashboard.genderDistribution') }}", function(data) {
                const ctx2 = document.getElementById('genderChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [data.male, data.female],
                            backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    }
                });
            });
        }
    </script>
@endsection

@section('content-isi')
    <div class="row items-push">

        <!-- Active Users Count -->
        <div class="col-sm-2">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Pengguna Aktif</div>
                    <div class="fs-2 fw-bold" id="activeUsersCount">0</div>
                </div>
            </div>
        </div>

        <!-- Participants by Date Chart -->
        <div class="col-xl-6">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <canvas id="participantsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gender Distribution Chart -->
        <div class="col-xl-4">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
