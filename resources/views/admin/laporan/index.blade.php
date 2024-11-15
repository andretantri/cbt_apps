@extends('template.full')

@section('title', 'Laporan Ujian')

@section('content-bc', 'Laporan Ujian')

@section('content-isi')
    <div class="row items-push">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Pilih Ujian dan Token</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="row push">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label class="form-label">Pilih Ujian<code>*</code></label>
                                <select name="exam_id" id="exam_id" class="form-control" required>
                                    <option value="">Silahkan Pilih</option>
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label class="form-label">Token<code>*</code></label>
                                <input type="text" name="token" class="form-control" placeholder="Masukkan Token"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-primary" type="button" onclick="fetchData()">Tampilkan Skor</button>
                        <button class="btn btn-primary" type="button" onclick="liveScore()">Live Skor</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="data"></div>
@endsection

@section('js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        function printCard(cardId) {
            var printContents = document.getElementById(cardId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function fetchData() {
            let examId = $('#exam_id').val();

            if (examId) {
                $.ajax({
                    url: '{{ route('admin.laporan.result') }}', // Change to the correct route if needed
                    method: 'POST',
                    data: {
                        exam_id: examId,
                        token: $('input[name="token"]').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.data').html(response);
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            }
        }

        function liveScore() {
            let examId = $('#exam_id').val();
            let token = $('input[name="token"]').val();

            let url = "{{ route('live-view', ['id' => ':examId', 'token' => ':token']) }}";
            url = url.replace(':examId', examId).replace(':token', token);
            window.open(url, '_blank');
        }


        $('#exam_id').on('change', function() {
            fetchData();
        });

        setInterval(fetchData, 15000);
    </script>
@endsection
