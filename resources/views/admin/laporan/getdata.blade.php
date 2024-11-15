<div class="row items-push">
    <div class="col-lg-12">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Hasil Skor Ujian Peserta</h3>
                <button onclick="printCard('scoreCard')" class="btn btn-primary float-right">Cetak Skor</button>
            </div>
            <div class="block-content block-content-full" id="scoreCard">
                <!-- Exam Score Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Total Dijawab</th>
                                <th>Total Skor TWK</th>
                                <th>Total Skor TIU</th>
                                <th>Total Skor TKP</th>
                                <th>Total Keseluruhan</th>
                                <th>Sisa Waktu</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($examAnswers != [])
                                @foreach ($examAnswers as $answer)
                                    @php
                                        $ses = \App\Models\ExamSession::where('exam_id', $examId)
                                            ->where('token', $token)
                                            ->where('user_id', $answer->user_id)
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $answer->user->name }}</td>
                                        <td><button class="btn btn-primary">{{ $answer->total_answer }}</button> / {{ count(json_decode($ses->question_id)) }}
                                        </td>
                                        <td>{{ $answer->total_twk }}</td>
                                        <td>{{ $answer->total_tiu }}</td>
                                        <td>{{ $answer->total_tkp }}</td>
                                        <td>{{ $answer->total_score }}</td>
                                        <td>{{ floor($ses->time_left / 60) }} Menit</td>
                                        <td>
                                            <button class="btn btn-danger"
                                                onclick="stopUser(
                                        {{ $ses->id }})"><span
                                                    class="fa fa-ban"></span></button>

                                            <button class="btn btn-primary"
                                                onclick="printHasil({{ $ses->id }})"><span
                                                    class="fa fa-print"></span></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" align="center">Belum Ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function stopUser(sesId) {
        Swal.fire({
            title: 'Yakin Ingin Menghentikan Ujian Peserta?',
            text: "Tidakan tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hentikan Proses Ujian!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.stopUserExam') }}', // Replace with your actual route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        session_id: sesId
                    },
                    success: function(response) {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        );
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while stop exam user.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }

    function printHasil(id) {
        let url = "{{ route('admin.report.userExam', ['id' => ':id']) }}";
        url = url.replace(':id', id);
        window.open(url, '_blank');
    }
</script>
