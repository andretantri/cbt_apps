<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Score - CAT CPNS TRIGAMA</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            height: 80vh;
            overflow-y: auto;
        }

        .table-container table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            /* Ensure the header is on top */
            background-color: #343a40;
            /* Background color matching the header */
        }

        .live-score-banner {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 10px;
            bottom: 0;
            width: 100%;
        }

        .scrolling {
            overflow-y: auto;
            white-space: nowrap;
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row live-score-banner">
            <div class="col-md-3">
                <h4>LIVE SCORE CAT CPNS</h4>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3 text-right">
                <img src="{{ asset('logo-trigama.png') }}" width="150px" alt="">
            </div>
        </div>

        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jumlah Soal Dijawab</th>
                        <th class="text-center">TWK</th>
                        <th class="text-center">TIU</th>
                        <th class="text-center">TKP</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody id="scoreTableBody">
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="live-score-banner footer">

                <div class="row">
                    <div class="col-md-3">
                        <div id="footer-clock"></div>
                        </p>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 text-right">
                        &copy; TRIGAMA SURAKARTA
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const id_exam = {{ $id }};
        const token = '{{ $token }}';
        var scores = '[]';

        fetch(`/getData?id_exam=${id_exam}&token=${token}`)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    scores = data; // Isi scores dengan data dari server jika berbentuk array
                } else {
                    console.error('Data is not an array:', data);
                    scores = []; // Pastikan scores tetap berbentuk array kosong jika respons bukan array
                }

                console.log(scores); // Lakukan apa saja yang Anda perlukan dengan data ini
                updateTable(); // Panggil updateTable setelah data diterima

                // Logic yang bergantung pada scores dipindahkan ke sini
                var visibleRows = 9;

                if (scores.length > visibleRows) {
                    var extraRows = scores.length - visibleRows;
                    if (extraRows < 0) {
                        extraRows = 2;
                    }
                    var scrollDuration = 5000 + (extraRows * 2000);
                } else {
                    var scrollDuration = 5000;
                }

                console.log('Scroll duration:', scrollDuration);
            })
            .catch(error => console.error('Error fetching data:', error));

        function updateTable() {
            var tbody = $('#scoreTableBody');
            tbody.empty(); // Clear the table body

            scores.forEach(function(score, index) {
                var row = `
                <tr>
                    <td align='center'>${index+1}</td>
                    <td>${score.user.name}</td>
                    <td align='center'>${score.total_answer}</td>
                    <td align='center'>${score.total_twk}</td>
                    <td align='center'>${score.total_tiu}</td>
                    <td align='center'>${score.total_tkp}</td>
                    <td align='center'>${score.total_score}</td>
                </tr>
            `;
                tbody.append(row);
            });
        }

        function autoScrollTable() {
            var container = $('.table-container');
            var scrollHeight = container.prop("scrollHeight");

            function scrollDown() {
                container.animate({
                    scrollTop: scrollHeight
                }, scrollDuration, 'linear', function() {
                    // Once scrolling down is done, scroll back to top and start again
                    container.animate({
                        scrollTop: 0
                    }, 3000, 'linear', scrollDown);
                });
            }

            scrollDown(); // Start scrolling down
        }

        $(document).ready(function() {
            updateTable(); // Initial load

            setInterval(updateTable, 10000); // Refresh data every 10 seconds
            autoScrollTable(); // Start auto scrolling
        });

        function updateClock() {
            var now = new Date();
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var day = days[now.getDay()];
            var date = now.getDate();
            var month = now.getMonth() + 1; // getMonth() is zero-based
            var year = now.getFullYear();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Format time to have leading zeros if necessary
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Format date to have leading zeros if necessary
            date = date < 10 ? '0' + date : date;
            month = month < 10 ? '0' + month : month;

            var timeString = day + ', ' + date + ' - ' + month + ' - ' + year + ' - ' + hours + ':' + minutes + ':' +
                seconds +
                ' WIB';

            document.getElementById('footer-clock').innerHTML = timeString;
        }

        // Update clock immediately and every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>

</body>

</html>
