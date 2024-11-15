@extends('template.full')

@section('title', 'Grafik Pengguna ')

@section('content-bc', 'Grafik Pengguna')

@section('css')
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('lineChart').getContext('2d');

            const examScores = @json($examScores);

            const labels = examScores.map(score => score.exam_name);
            const data = examScores.map(score => score.total_score);

            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Skor',
                        data: data,
                        borderColor: '#5c4532',
                        backgroundColor: 'rgba(92, 69, 50, 0.2)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h4>Grafik Perkembangan Pengguna ({{ $user->name }})</h4>
            <canvas id="lineChart"></canvas>
        </div>

    </div>
@endsection
