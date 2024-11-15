<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Skor Try Out</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f0e9;
            color: #5c4532;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 200px;
        }

        h1 {
            color: #5c4532;
            font-size: 24px;
            margin-top: 10px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .chart-scores {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pie-chart {
            width: 40%;
        }

        .scores {
            width: 40%;
        }

        .scores p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .total-score {
            text-align: center;
            margin-top: 20px;
            font-size: 22px;
            border-radius: 15px;
        }

        .total-score p {
            background-color: #5c4532;
            color: #fff;
            padding: 10px 0;
            border-radius: 30px;
        }

        @media print {
            .container {
                width: 100%;
                max-width: none;
            }

            .pie-chart {
                width: 100% !important;
            }

            .total-score {
                background-color: #5c4532 !important;
                color: #fff !important;
            }

            canvas {
                background: none !important;
                /* Ensure canvas is visible */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="{{ asset('logo-trigama.png') }}" alt="Logo Trigama">
            </div>
            <h1>PEROLEHAN SKOR TRY OUT</h1>
        </header>

        <div class="content">
            <div class="info">
                <p><strong>Nama Lengkap:</strong> <span id="nama">{{ $info['user'] }}</span></p>
                <p><strong>Tanggal Try Out:</strong> <span
                        id="tanggal">{{ date('d M Y', strtotime($info['tanggal'])) }}</span></p>
            </div>

            <div class="chart-scores">
                <div class="pie-chart">
                    <canvas id="myPieChart"></canvas>
                </div>

                <div class="scores">
                    <div class="total-score" style="background-color: #5c4532; color: #fff;">
                        <p><strong>Skor TWK:</strong></p>
                    </div>
                    <center><span id="skorTwk">{{ $data->total_twk }}</span></center>
                    <div class="total-score" style="background-color: #5c4532; color: #fff;">
                        <p><strong>Skor TIU:</strong></p>
                    </div>
                    <center><span id="skorTiu">{{ $data->total_tiu }}</span></center>
                    <div class="total-score" style="background-color: #5c4532; color: #fff;">
                        <p><strong>Skor TKP:</strong></p>
                    </div>
                    <center><span id="skorTkp">{{ $data->total_tkp }}</span></center>
                </div>
            </div>

            <div class="total-score" style="background-color: #5c4532; color: #fff;">
                <p><strong>Total Skor Keseluruhan:</strong> <span id="totalSkor">{{ $data->total_score }}</span></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('myPieChart').getContext('2d');
            const data = {
                labels: ['TIU', 'TWK', 'TKP'],
                datasets: [{
                    label: 'Skor',
                    data: [10, 10, 10], // Ganti sesuai nilai skor masing-masing
                    backgroundColor: ['#5c4532', '#9b7d67', '#7e614c'],
                }]
            };

            const config = {
                type: 'pie',
                data: data,
            };

            const myPieChart = new Chart(ctx, config);

            setTimeout(() => {
                window.print();
            }, 1000);
        });
    </script>
</body>

</html>
